<?php

/**
 * WebController is the customized base controller class for web pages.
 * All controller classes generating web output for this application should extend from this base class.
 */
class WebController extends Controller
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	/**
	 * @var array the alternate languages pages of the current page. The value of this property will
	 * be of type array("locale-id"=>"url") and include the current language; for example array("en"=>"/en/cat/brands.html", "fr"=>"/fr/cat/marques.html").
	 */
	public $alternatives=array();
	
	
	/**
	 * This method attempts to find the visitor country code. Only work if the request passes through Cloudflare.
	 * @return string a country code in the ISO 3166-1 Alpha 2 format.
	 */
	public function getVisitorCountryCode() {
		
		return isset($_SERVER["HTTP_CF_IPCOUNTRY"]) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : "CA";
		
	}
	
	
	
	/**
	 * @var bool whe true, a prompt can appear at the top of the page asking the user to create a password if none is set.
	 * Should be set to false during the checkout process. 
	 */
	public $can_prompt_for_password_set=true;
	
	
	
	/**
	 * @var str the page description to insert in the meta tags.
	 */
	public $pageDescription=null;
	
	/**
	 * @var str the menu title to be inserted at the top of the sidebar
	 */
	public $menuTitle=null;
	
	/**
	 * @var bool current request should be treated as the site's home page
	 */
	public $isHomePage=false;
	
	
	/**
	 * This method is invoked right before an action is to be executed (after all possible filters.)
	 * You may override this method to do last-minute preparation for the action.
	 * @param CAction $action the action to be executed.
	 * @return boolean whether the action should be executed.
	 */
	protected function beforeAction($action)
	{
		// When on B2B sites, check if the user is connected OR if user is currently connecting prior to allowing it in
		
		if ($this->isB2b() && Yii::app()->user->isGuest && !isset($_GET["email"])) {
			// None of these, redirect the user to KEM's sign in prompt
			$redirect_domain = Yii::app()->language === "fr" ? "https://kle-en-main.com" : "https://kemsolutions.com";
			$this->redirect($redirect_domain . "/CloudServices/index.php/Users/default/b2bGateway");
		}
		
		
		$alternatives = array();
		foreach (Yii::app()->request->languages as $language){
			$alternatives[$language] = $this->createAbsoluteUrl('', array("language"=>$language));
		}
		$this->alternatives = $alternatives;
		return parent::beforeAction($action);
	}
	
	
	/**
	 * Returns a dataprovider with the top categories (ones with no parent) so they can be displayed in a menu on each page (if needed)
	 * @return CActiveDataProvider the data provider for each top category available.
	 */
	protected function topCategoriesDataProvider(){
		
		if ($this->_topCategoriesDataProvider !==null){
			return $this->_topCategoriesDataProvider;
		}
		
		$dataProvider=new CActiveDataProvider('Category', array(
		    'criteria'=>array(
		        'condition'=>'parent_category IS NULL',
		        'with'=>array('categoryLocalizations'),
		    ),
		    'pagination'=>false,
		));
		
		$this->_topCategoriesDataProvider = $dataProvider;
		return $this->_topCategoriesDataProvider;
	}
	public $_topCategoriesDataProvider = null;
	
	
	/**
	 * Returns a dataprovider with the top categories' localizations so they can be displayed in a menu on each page (if needed)
	 * @return CArrayDataProvider the data provider for each top category's localization available.
	 */
	protected function topCategoriesLocalizationsDataProvider(){
		
		if ($this->_topCategoriesLocalizationsDataProvider !==null){
			return $this->_topCategoriesLocalizationsDataProvider;
		}
		
		$localizations = array();
		foreach ($this->topCategoriesDataProvider()->getData() as $topCategory){
			$localizedCat = $topCategory->localizationForLanguage(Yii::app()->language);
			if ($localizedCat !== null)
				$localizations[] = $localizedCat;
		}
		
		$dataProvider = new CArrayDataProvider($localizations);
		
		
		
		$this->_topCategoriesLocalizationsDataProvider = $dataProvider;
		return $this->_topCategoriesLocalizationsDataProvider;
	}
	public $_topCategoriesLocalizationsDataProvider = null;
	
	
	/**
	 * Returns an Order object with the cart status. Is either determined by session or user.
	 * @return CActiveDataProvider the data provider for each top category available.
	 */
	protected function getCart(){
		
		if (!Yii::app()->user->isGuest) {
			// User is connected. Use or build her cart
			
			// Find a cart for user
			
			if (Yii::app()->session['cart_id']){
				
				$order =  Order::model()->findByPk(Yii::app()->session['cart_id']);
				
				// We must make sure that the order is in the cart state AND that it doesn't belong to a user
				if ($order !== null && $order->cart && (!$order->user_id || $order->user_id === Yii::app()->user->user->id)){
					
					if (!$order->user_id){
						// user id is NOT set for that cart, associate it with current user's account
						$order->user_id = Yii::app()->user->user->id;
						$order->save();
					}
					
					return $order;
					
				}
				
				// It seems we can't find a cart by session ID. Let's make a db request.
				$order = Order::model()->find("cart=:cart AND user_id=:user_id", array(':cart' => "1", ":user_id"=>Yii::app()->user->user->id));
				
				if ($order !== null) {
					return $order;
				}
				
			}
			
			
			// No cart whatsoever is found, create one.
			
			$order = new Order;
			$order->user_id = Yii::app()->user->user->id;
			
			
			
		} else {
			// User is not connected. Retrieve the cart or build it from scratch.
			$order = new Order;
		}
		
		// Try to retrieve a potential cart from the session
		if (Yii::app()->session['cart_id']){
			
			$order_from_session =  Order::model()->findByPk(Yii::app()->session['cart_id']);
			
			// We must make sure that the order is in the cart state AND that it doesn't belong to a user
			if ($order_from_session !== NULL && $order_from_session->cart && !$order->user_id){
				
				return $order_from_session;
				
			}
			
		}
			

		
		$order->cart = 1;
		$order->save();

		Yii::app()->session['cart_id'] = $order->id;
		
		
		return $order;


		
		
	}
	
	
}