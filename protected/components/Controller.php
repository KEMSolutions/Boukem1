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
	protected function renderJSON($data)
	{
	    header('Content-type: application/json');
	    echo CJSON::encode($data);

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
	
}