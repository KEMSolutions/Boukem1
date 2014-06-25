<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property integer $id
 * @property integer $user_id
 * @property integer $cart
 * @property string $timestamp
 * @property string $status
 *
 * The followings are the available model relations:
 * @property User $user
 * @property OrderDetails $orderDetails
 * @property Product[] $products
 */
class Order extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, cart', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>64),
			array('status','in','range'=>array('pending', 'paid', 'canceled', 'complete', 'partial_shipment'),'allowEmpty'=>true),
			array('timestamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, cart, timestamp, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'orderDetails' => array(self::HAS_ONE, 'OrderDetails', 'order_id'),
			'products' => array(self::MANY_MANY, 'Product', 'order_has_product(order_id, product_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'cart' => 'Cart',
			'timestamp' => 'Timestamp',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('cart',$this->cart);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	/// CUSTOM methods
	
	/**
	 * A JSON string (base64 encoding) to post to our payment processor (KEM payment) and order printer.
	 * @return string order data to display to the end user or print on packing slip
	 */
	public function frontendData(){
		
		$orderDetails = $this->orderDetails;
		
		// Only complete orders with order details can be processed.
		if ($orderDetails === null){
			return null;
		}
		$user = $this->user;
		
		// Build a simple array with order data
		$orderdict = array();
		$orderdict["id"] =  $this->id;
		$orderdict['user_id'] = $this->user_id;
		$orderdict['timestamp'] = $this->timestamp;
		$orderdict['shipping_type'] = $orderDetails->shipping_type;
		
		$orderdict["total"] =  $orderDetails->total;
		$orderdict["subtotal"] =  $orderDetails->subtotal;
		$orderdict["taxes"] =  $orderDetails->taxes;
		$orderdict["discount"] = 0.0;
		$orderdict["delivery"] =  $orderDetails->shipping;
		$orderdict["balance"] =  $this->getBalance();
		
		$orderdict['email'] = $this->user->email;
		
		$billing = $orderDetails->billingAddress;
		$orderdict['billing'] = array();
		$orderdict['billing']['firstname'] = $user->firstname;
		$orderdict['billing']['lastname'] = $user->lastname;
		$orderdict['billing']['street1'] = $billing->street1 ? CHtml::encode($billing->street1) : null;
		//$orderdict['billing']['street2'] = $billing->street2 ? CHtml::encode($billing->street2) : null;
		$orderdict['billing']['postcode'] = $billing->postcode ? CHtml::encode($billing->postcode) : null;
		$orderdict['billing']['city'] = $billing->city ? CHtml::encode($billing->city) : null;
		$orderdict['billing']['region'] = $billing->region ? CHtml::encode($billing->region) : null;
		$orderdict['billing']['country'] = $billing->country ? CHtml::encode($billing->country) : null;
		
		$shipping = $orderDetails->shippingAddress;
		$orderdict['shipping'] = array();
		$orderdict['shipping']['firstname'] = $user->firstname;
		$orderdict['shipping']['lastname'] = $user->lastname;
		$orderdict['shipping']['street1'] = $shipping->street1 ? CHtml::encode($shipping->street1) : null;
		//$orderdict['shipping']['street2'] = $shipping->street2 ? CHtml::encode($shipping->street2) : null;
		$orderdict['shipping']['postcode'] = $shipping->postcode ? CHtml::encode($shipping->postcode) : null;
		$orderdict['shipping']['city'] = $shipping->city ? CHtml::encode($shipping->city) : null;;
		$orderdict['shipping']['region'] = $shipping->region ? CHtml::encode($shipping->region) : null;;
		$orderdict['shipping']['country'] = $shipping->country ? CHtml::encode($shipping->country) : null;;
		
		$orderdict['telephones'] = array();
		foreach ($user->userPhones as $phone){
			$orderdict['telephones'][] = array("number"=>$phone->number, 'can_receive_sms'=>$phone->sms_opt_in);
		}
		
		// Build a list of items
		$orderdict['items'] = array();
		$dataProvider=new CActiveDataProvider('OrderHasProduct', array(
		    'criteria'=>array(
		        'condition'=>'order_id=' . $this->id,
		        'with'=>array('product'),
		    ),
		    'pagination'=>false,
		));
		
		
		$firstname = $user->firstname ? CHtml::encode($user->firstname) . " " : "";
		$lastname = $user->lastname ? CHtml::encode($user->lastname) : "";
		$orderdict["name"] = $firstname . $lastname;
		
		$locale = $this->user ? $user->locale->long_code : "en_CA";
		
		$orderdict['locale'] = $locale;
		foreach ($dataProvider->getData() as $relationship){
			
			$product = $relationship->product;
			$localization = $product->localizationForLanguage($locale, true);
			
			$itemdict = array("id"=>$relationship->product_id, "name"=>$localization->name, 'sku'=>$product->sku, 'barcode'=>$product->barcode, "quantity"=>$relationship->quantity, "price_paid"=>$relationship->price_paid, "brand"=>array());
			
			$brand_id = $relationship->product->brand_id;
			if ($brand_id){
				
				$brand_localization = CategoryLocalization::model()->find("category_id=:category_id AND locale_id=:locale_id", array(":category_id" => $brand_id, ":locale_id" => $user->locale_id));
				
				
				$itemdict["brand"]["id"] = $brand_id;
				if ($brand_localization){
					$itemdict["brand"]["name"] = $brand_localization->name;
				} else if (count($order->brand->categoryLocalizations) > 0) {
					$any_localization =  $order->brand->categoryLocalizations[0];
					$itemdict["brand"]["name"] = $any_localization->name;
				} else {
					$itemdict["brand"]["name"] = null;
				}
				
			} else {
				$itemdict["brand"]["name"] = null;
				$itemdict["brand"]["id"] = null;
			}
			
			$orderdict['items'][] = $itemdict;
		}
		
		$orderdict["confirm_url"] = Yii::app()->createAbsoluteUrl('cart/confirm', array('order'=>$this->id));
		
		return $orderdict;
	}
	
	/**
	 * Returns an encrypted string (base64 encoding) to post to our payment processor (KEM payment).
	 * @return string encrypted order data to display to the end user (NOT used for payment validation)
	 */
	public function encryptedFrontendData()
	{
		
		$orderdict = $this->frontendData();
		
		$securityManager = new CSecurityManager;
		$securityManager->cryptAlgorithm = array('rijndael-256', '', 'cbc', '');
		$securityManager->encryptionKey =  $this->id . Yii::app()->params['outbound_api_secret'];
		
		
		
		
		return base64_encode($securityManager->encrypt(json_encode($orderdict)));
		
	}
	
	
	/**
	 * Calculate the remaining balance for the order 
	 * A negative balance means the order was overcharged and the exceding amount should be refunded to reach 0.
	 * @return float order's balance 
	 */
	public function getBalance()
	{
		$orderDetails = $this->orderDetails;
		
		// Only complete orders with order details can be processed.
		if ($orderDetails === null){
			return null;
		}
		
		$balance = $this->orderDetails->balance;
		
		return $balance;
	}
	
}
