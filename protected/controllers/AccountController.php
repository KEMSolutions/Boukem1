<?php

class AccountController extends WebController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			
			array('allow',
			'actions'=>array('index', 'updatePassword'),
			'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		$this->render('index',array());
	}
	
	public function actionUpdatePassword(){
		
		$model=new UpdatePasswordForm;
		
		if(isset($_POST['UpdatePasswordForm']))
		{
			$model->attributes=$_POST['UpdatePasswordForm'];
			if($model->validate()){
				
				Yii::app()->user->user->password = CPasswordHelper::hashPassword($model->new_password);
				Yii::app()->user->user->save();
				
				Yii::app()->user->setFlash('success', Yii::t("app", "Le mot de passe de votre compte a été modifié. Veuillez dès maintenant utiliser votre nouveau mot de passe pour vous identifier."));
				$this->redirect("index");
				
			}
				
		}
		
		$this->render('updatePassword',array('model'=>$model));
	}
	
}
