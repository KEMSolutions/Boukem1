<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class APIController extends Controller
{
	/**
	* Extract json from POST body and convert it to a native php array.
	* @return array the native php array json encoded in the request body
	*/
	protected function extractJSON(){
		if ($this->_request_payload !== null){
			return $this->_request_payload;
		}
		$postbody = Yii::app()->request->getRawBody();
		$arr = json_decode($postbody);
		$this->_request_payload = $arr;
		return $this->_request_payload;
	}
	private $_request_payload = null;
	
	
	/**
	* Every API request comes with a sha512 hash included in a X-Kem-Signature HTTP header. This function will compare that signature with a similar signature generated using the private key stored on our side.
	*/
	protected function cheakApiRequestValidity(){
		
		// We use this function as getallheaders() is not available on nginx
		function parseRequestHeaders() {
		    $headers = array();
		    foreach($_SERVER as $key => $value) {
		        if (substr($key, 0, 5) <> 'HTTP_') {
		            continue;
		        }
		        $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
		        $headers[$header] = $value;
		    }
		    return $headers;
		}
		
		$headers = parseRequestHeaders();
		if (isset($headers['X-Kem-Signature'])){
			$signature = $headers['X-Kem-Signature'];
		} else {
			$signature = null;
		}
		if (isset($headers["X-Kem-Salt"])){
			$salt = $headers["X-Kem-Salt"];
		} else {
			$salt = null;
		}
		if (isset($headers["X-Kem-User"])){
			$client = $headers["X-Kem-User"];
		} else {
			$client = null;
		}
		
		
		$body = Yii::app()->request->getRawBody($client);
		
		if ($this->public_api) {
			
			// This is a public api call
			
			$user = User::model()->findByPk($client);
			
			
			
			if ($this->require_authentification){
				// This call requires authentification
				#TODO Implement
			} else {
				
				// This is a public api call with no authentification
				return true;
				
			}
			
			
			
			
		} else {
			// Private APIs require full authentication with KEM secret
			// Generate a signature combining salt+body+secret
			$concatenated_string = $salt . $body . Yii::app()->params['inbound_api_secret'];
			$generated_signature = hash('sha512', $concatenated_string);
		
			// Check if the generated signature on both sides match.
			// NEVER trust that simple mechanism for any sensitive transaction (anything regarding payments)
			if ($generated_signature === $signature && $client === Yii::app()->params['inbound_api_user']){
				return true;
			}
		}
		
		
		return false;
		
	}
	

	/**
	 * This method is invoked right before an action is to be executed (after all possible filters.)
	 * You may override this method to do last-minute preparation for the action.
	 * @param CAction $action the action to be executed.
	 * @return boolean whether the action should be executed.
	 */
	protected function beforeAction($action)
	{
		$valid_request = $this->cheakApiRequestValidity();
		
		if (!$valid_request){
			throw new CHttpException(403,'Request signature verification failed.');
		}
		
		return $valid_request;
	}
	
	
	protected $require_authentification = true;
	protected $public_api = false;
	
}