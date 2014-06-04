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
	 * @var str the page description to insert in the meta tags.
	 */
	public $pageDescription=null;
	
	
	
	
	/**
	 * Returns the suggested locale for the specified page based on user preference
	 * @return str the locale id the page should be displayed in.
	 */
	/*
	protected function suggestedPageLocale() {
		return "fr";
	}*/
	
	
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
	private $_topCategoriesDataProvider = null;
	
	
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