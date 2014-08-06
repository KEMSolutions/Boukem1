<?php

class DefaultController extends APIController
{
	public function actionIndex()
	{
		//$this->render('index');
	}
	
	public function actionVersion()
	{
		$this->renderJSON(array("application"="boukem", "version"=>1.0));
	}
	
}