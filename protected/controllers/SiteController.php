<?php

class SiteController extends WebController
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}
	
	/**
	 * Displays the registration form
	*/
	
	public function actionRegister()
	{
		
		if (!Yii::app()->user->isGuest){
			$this->redirect('/');
		}
		
	    $model=new User('register');

	    // uncomment the following code to enable ajax-based validation
	    

	    if(isset($_POST['User']))
	    {
			$model->attributes=$_POST['User'];
			
			$original_password = $model->password;
			$hashed_password = CPasswordHelper::hashPassword($original_password);
			$model->password = $hashed_password;
			
			$randomManager = new CSecurityManager;
			$randomString = $randomManager->generateRandomString(16, true);
			$model->verification_string = $randomString; 
			
			$firstname = $model->firstname;
			$lastname = $model->lastname;
			
			$model->locale_id = Yii::app()->language;
			
			// Check if we received an existing email field with a user with no password
			$existing_user = User::model()->find("email =:email", array(":email"=>$model->email));
			if ($existing_user !== null && $existing_user->password === null){
				// User exists AND is currently not assigned a password. Log user in and assign the received password
				$model = $existing_user;
				$model->firstname = $firstname;
				$model->lastname = $lastname;
				$model->password = $hashed_password;
				$model->verification_string = $randomString;
				
			}
			
	        
			
			
	        if($model->validate() && $model->save())
	        {
	            $form=new LoginForm;
				$form->username = $model->email;
				$form->password = $original_password;
				$form->login();
				
				Yii::app()->user->setFlash('success',Yii::t("app", 'Féliciations, votre compte a été créé!'));
				$this->redirect(Yii::app()->user->returnUrl);
	        }
	    }
	    $this->render('register',array('model'=>$model));
	}
	
	
	
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;
		
		$this->pageTitle = Yii::t("app", "Connexion") . " - " . Yii::app()->name;
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}