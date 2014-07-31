<?php

class CViewStaticAction extends CViewAction
{
	
 
	public function onBeforeRender($event)
	{
		
		$controller = $this->controller;
		$alternatives = array();
		
		foreach (Yii::app()->request->languages as $language){
			$alternatives[$language] = $controller->createAbsoluteUrl('', array("language"=>$language, "view"=>$_GET['view']));
		}
		
		$controller->alternatives = $alternatives;
		
	}
   
}
?>