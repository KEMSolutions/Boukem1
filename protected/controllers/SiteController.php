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
				'class'=>'CViewStaticAction',
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
		
		$this->isHomePage = true;
		
		if (Yii::app()->user->isGuest){
			$cache_id = Yii::app()->request->hostInfo . " SiteController:[indexForLanguage] " . Yii::app()->language;
			$cache_duration = 10;//10800;
		} else {
			$cache_id = Yii::app()->request->hostInfo . " SiteController:[indexForLanguageUser] " . Yii::app()->language . " - " . Yii::app()->user->user->id;
			$cache_duration = 1600;
		}
		
		$layout_html = Yii::app()->cache->get($cache_id);
		
		if (!$layout_html){
			
			$layout_parameters = array('storeid'=>Yii::app()->params['outbound_api_user'], 'storekey'=>Yii::app()->params['outbound_api_secret'], 'locale'=>Yii::app()->language . "_CA", 'layout_type'=>Yii::app()->params['mainPageLayout']);
			if (!Yii::app()->user->isGuest){
				$layout_parameters["email"] = Yii::app()->user->user->email;
			}
			
			$output = Yii::app()->curl->get("https://kle-en-main.com/CloudServices/index.php/Layout/boukem/view", $layout_parameters);
			
			
			$base_dict = json_decode($output);
			

			if (Yii::app()->params['mainPageLayout'] === "limited") {
				
				$layout_html = $this->renderPartial('_index_limited_layout', array("items"=>$base_dict), true);
				
			} else {
				
				$rebatesDataProvider=new CActiveDataProvider('ProductRebate', array(
				    'criteria'=>array(
						'limit'=>10,
				        'with'=>array('product', 'product.productLocalization'),
				    ),
				    'pagination'=>false,
				));
			
				$layout_html = $this->renderPartial('_index_layout', array("items"=>$base_dict, 'rebates'=>$rebatesDataProvider), true);
				
				
			}
			
			Yii::app()->cache->set($cache_id, $layout_html, $cache_duration);
		}
		
		
		$this->render('index', array("layout_html"=>$layout_html));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$this->can_prompt_for_password_set = false;
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else {
				
				// Load the redirect map to keep Magento's urls valid
				$equavalency_dict_file_path = Yii::app()->basePath . "/redirect_map.json";
				$equavalency_dict_string = file_get_contents($equavalency_dict_file_path);
				$equavalency_dict = json_decode($equavalency_dict_string, true);
				
				// Get current path info without the /en/ or /fr/ part
				$current_url_particle = Yii::app()->request->getPathInfo();
				
				
				
				if (isset($equavalency_dict[$current_url_particle])){
					// Make a permanent redirection
					$this->redirect("/fr/prod/" . $equavalency_dict[$current_url_particle] . ".html", $terminate=true, $statusCode=301);
				}
				
				
				$this->render('error', $error);
				
			}
				
		}
	}

	
	
	/**
	 * Displays the registration form
	*/
	
	public function actionRegister()
	{
		
		if (!Yii::app()->user->isGuest){
			$this->redirect('/');
		}
		
		if ($this->isB2b()){
			
			// Redirect to KEM login page
			$redirect_domain = Yii::app()->language === "fr" ? "https://kle-en-main.com" : "https://kemsolutions.com";
			$this->redirect($redirect_domain . "/CloudServices/index.php/Users/default/b2bGateway");
			
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
				
				
				// ping KEMConsole with the user
				$output = Yii::app()->curl->post("https://kle-en-main.com/CloudServices/index.php/BoukemAPI/user/updateUserData", array('customer_id'=>$model->id, 'store_id'=>Yii::app()->params['outbound_api_user'], 'store_key'=>Yii::app()->params['outbound_api_secret']));
				
				
				Yii::app()->user->setFlash('success',Yii::t("app", 'Félicitations, votre compte a été créé!'));
				$this->redirect(Yii::app()->user->returnUrl);
	        }
	    }
	    $this->render('register', array('model'=>$model));
	}
	
	/**
	 * Return a small page jquery will insert to the main layout's dom so a modal can be displayed when the user adds an object to her cart
	 */
	public function actionModalCart(){
		echo $this->renderPartial('modal_cart', array(), true, true);
	}
	
	
	public function actionSitemap(){
		
		
		header('Content-type: application/xml');
		
		$cache_id = "Sitemap";
		$output_string = Yii::app()->cache->get($cache_id);
		
		if (!$output_string){
			ini_set('memory_limit', '512000000');
			set_time_limit(300);
		
			$output_string = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xhtml=\"http://www.w3.org/1999/xhtml\">\n";
		
			// Add the home page
			$locales = Locale::model()->findAll();
			$localizedHomepages = "";
			foreach ($locales as $locale){
			
				$localizedHomepages .= "<xhtml:link rel=\"alternate\" hreflang=\"" . $locale->id . "\" href=\"" . $this->createAbsoluteUrl("site/index", array('language'=>$locale->id)) . "\"/>";
		
			}
		
			foreach ($locales as $locale){
			
				$output_string .= "<url>";
			
				$output_string .= "<loc>" . $this->createAbsoluteUrl("site/index", array('language'=>$locale->id)) . "</loc>";
				$output_string .= $localizedHomepages;
			
				$output_string .= "</url>";
		
			}
		
		
			// Add all categories
			$all_categories = Category::model()->findAll(array("limit"=>10000));
		
			foreach ($all_categories as $category){
			
				$localizedLinks = "";
				foreach ($category->categoryLocalizations as $localization){
				
					$localizedLinks .= "<xhtml:link rel=\"alternate\" hreflang=\"" . $localization->locale_id . "\" href=\"" . $this->createAbsoluteUrl("category/view", array('slug'=>$localization->slug, 'language'=>$localization->locale_id)) . "\"/>";
				
				}
			
				foreach ($category->categoryLocalizations as $localization){
				
					$output_string .= "<url>";
				
					$output_string .= "<loc>" . $this->createAbsoluteUrl("category/view", array('slug'=>$localization->slug, 'language'=>$localization->locale_id)) . "</loc>";
					$output_string .= $localizedLinks;
				
					$output_string .= "</url>";
				
				}
			
			
			
			}
		
			// Same for products
		
			$all_products = Product::model()->findAll(array("limit"=>10000, "offset"=>0));
		
			foreach ($all_products as $product){
			
				$localizedLinks = "";
				foreach ($product->productLocalizations as $localization){
				
					$localizedLinks .= "<xhtml:link rel=\"alternate\" hreflang=\"" . $localization->locale_id . "\" href=\"" . $this->createAbsoluteUrl("product/view", array('slug'=>$localization->slug, 'language'=>$localization->locale_id)) . "\"/>";
				
				}
			
				foreach ($product->productLocalizations as $localization){
				
					$output_string .= "<url>";
				
					$output_string .= "<loc>" . $this->createAbsoluteUrl("product/view", array('slug'=>$localization->slug, 'language'=>$localization->locale_id)) . "</loc>";
					$output_string .= $localizedLinks;
				
					$output_string .= "</url>";
				
				}
			
			
			
			}
		
			$output_string .= "</urlset>";
			Yii::app()->cache->set($cache_id, $output_string, 604800);
			
		}
		
		
		
		echo $output_string;
		
		foreach (Yii::app()->log->routes as $route) {
	        if($route instanceof CWebLogRoute) {
	            $route->enabled = false; // disable any weblogroutes
	        }
	    }
	    Yii::app()->end();
		
	}
	
	public function actionCreatePassword(){
		
		if ($this->isB2b()){
			throw new CHttpException(403,'Not authorized');
		}
		
		$user = !Yii::app()->user->isGuest ? Yii::app()->user->user : null;
		
		if ($user === null){
			throw new CHttpException(403,'Not authorized');
		}
		
		
		if ($user->password !== null){
			throw new CHttpException(403,'Not authorized');
		}
		
		$password = Yii::app()->request->getPost("password", null);
		if ($password === null || $password === ""){
			throw new CHttpException(400,'Incorrect password.');
		}
		
		$user->password = CPasswordHelper::hashPassword($password);
		$user->save();
		
		Yii::app()->user->setFlash('success',Yii::t("app", 'Féliciations, votre mot de passe est enregistré!'));
		$this->redirect(Yii::app()->user->returnUrl);
	}
	
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if ($this->isB2b()){
			
			// Redirect to KEM login page
			$redirect_domain = Yii::app()->language === "fr" ? "https://kle-en-main.com" : "https://kemsolutions.com";
			$this->redirect($redirect_domain . "/CloudServices/index.php/Users/default/b2bGateway");
			
		}
		
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
	 * Login through B2B authentication
	 */
	public function actionLoginb2b($email, $timestamp, $check, $hash, $discount=0.2)
	{
		if (!$this->isB2b()){
			// Redirect to the home page
			$this->redirect(Yii::app()->homeUrl);
		}
		
		if (!Yii::app()->user->isGuest){
			// User is already logged in
			$this->redirect(Yii::app()->homeUrl);
		}
		
		// Check if the hash is valid
		$concatenated_string = $email . $timestamp . $check . $discount . Yii::app()->params['inbound_api_secret'];
		$expected_hash = hash('sha512', $concatenated_string);
		
		if ($expected_hash !== $hash) {
			throw new CHttpException(403,'Not authorized');
		}
		
		
		// Compare timestamp to ensure it's current. We accept up to 30 seconds of delay
		$current_timestamp = time();
		$down_limit = $current_timestamp - 15;
		$up_limit = $current_timestamp + 15;
		
		if ($timestamp <= $down_limit || $timestamp >= $up_limit){
			throw new CHttpException(403,'Not authorized');
		}
		
		// Log user in
		Yii::app()->user->createGuestUser($email);
		
		
		$this->redirect(Yii::app()->homeUrl);
	}
	
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		if ($this->isB2b()){
			
			// Also disconnect on kem
			$redirect_domain = Yii::app()->language === "fr" ? "https://kle-en-main.com" : "https://kemsolutions.com";
			$this->redirect($redirect_domain . "/CloudServices/index.php/Site/logout");
			
		} else {
			$this->redirect(Yii::app()->homeUrl);
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function actionTest(){
		
		$order = Order::model()->findByPk(238);
		
		echo $order->getPaypalPaymentLink(); 
		
	}
	
	
}