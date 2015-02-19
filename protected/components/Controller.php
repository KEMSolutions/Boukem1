<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * Return data to browser as JSON and end application.
	 * @param array $data
	 */
	protected function renderJSON($data, $pretty=false)
	{
	    header('Content-type: application/json');
		if ($pretty){
			if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
				// 5.4 and up
				//eval('$localizationForProduct = $this->productLocalizations[0];');
				echo json_encode($data, JSON_PRETTY_PRINT);
			} else {
				// Older than 5.4 do not support pretty print
				echo json_encode($data);
			}
			
			
		} else {
		    echo CJSON::encode($data);
		}
	    
	    foreach (Yii::app()->log->routes as $route) {
	        if($route instanceof CWebLogRoute) {
	            $route->enabled = false; // disable any weblogroutes
	        }
	    }
	    Yii::app()->end();
	}
	
	
	/**
	 * Check whether the current store is a b2b oriented store. B2B stores are only available for login through a KEMConsole application, and prices are multiplied using the 'b2b_rebate_multiplier' config value.
	 * @return bool indicating if the current store is a b2b store (returns false if not).
	 */
	public function isB2b(){
		
		if (Yii::app()->request->serverName === "b2b.boutiquekem.com"){
			return true;
		}
		
		return false;
	}
	
	
	
	/**
	 * If we're currently running on a .local domain name, we'll switch to a dummy cache so we don't have to install memcached in our Homestead boxes during development.
	 */
	private function updateCache() {
		
		if (strpos(Yii::app()->request->serverName,'.local') !== false || strpos(Yii::app()->request->serverName,'dev.boutiquekem.com') !== false) {
		    Yii::app()->setComponent('cache', new CDummyCache());
			header('X-KEM-Server: dev');
		} else {
			Yii::app()->setComponent('cache', new CMemCache());
			Yii::app()->cache->setServers(array(
			    array(
			        'host'=>'127.0.0.1',
			        'port'=>11211,
			        'weight'=>60,
			    ),
			));
		}
	}
	
	function init() {
	    $this->updateCache();
	}
	
}