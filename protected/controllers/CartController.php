<?php

class CartController extends WebController
{
	
	
	
	private function taxesForProvinceCountryValue($province, $country, $value){
		
		// Calculate taxes
		
		if ($country === "CA"){
			// Calculate taxes
			
			if ($province === "AB"){
				return $value * 0.05;
			} else if  ($province === "BC"){
				return $value * 0.05;
			}  else if  ($province === "MB"){
				return $value * 0.05;
			} else if  ($province === "NB"){
				return $value * 0.13;
			} else if  ($province === "NS"){
				return $value * 0.15;
			} else if  ($province === "ON"){
				return $value * 0.13;
			} else if  ($province === "PE"){
				return $value * 0.14;
			} else if  ($province === "QC"){
				return $value * 0.1498;
			} else if  ($province === "SK"){
				return $value * 0.05;
			} else if  ($province === "NT"){
				return $value * 0.05;
			} else if  ($province === "NU"){
				return $value * 0.05;
			} else if  ($province === "YT"){
				return $value * 0.05;
			} else {
				return $value * 0.1498;
			}
			
		} else {
			return 0.0;
		}
		
	}
	
	
	private function subtotalForCart($cart){
		
		$dataProvider=new CActiveDataProvider('OrderHasProduct', array(
		    'criteria'=>array(
		        'condition'=>'order_id=' . $cart->id,
		        'with'=>array('product'),
		    ),
		    'pagination'=>false
		));
		
		// Produce the subtotal
		$total_value = 0.0;
		$total_item_qty = 0;
		foreach ($dataProvider->getData() as $relationship){
			$total_value += $relationship->quantity * $relationship->price_paid;
			$total_item_qty += $relationship->quantity;
		}
		
		return $total_value;
		
	}
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'ajaxOnly + add, remove, update, estimate, prepare, order',
		);
	}
	
	
	
	public function actionPrepare(){
		
		$country = Yii::app()->request->getPost("country", null);
		$province = Yii::app()->request->getPost("province", null);
		$postcode = Yii::app()->request->getPost("postcode", null);
		$shipping_type = Yii::app()->request->getPost("shipping_type", null);
		
		$shipping_estimated_value = Yii::app()->request->getPost("shipping_estimated_value", null);
		
		if ($country === null || $shipping_type === null || $shipping_estimated_value === null){
			throw new CHttpException(400,'The request is invalid.');
		}
		
		$cart = $this->getCart();
		
		if ($cart->orderDetails){
			$details = new OrderDetails;
			$details->order_id = $cart->id;
			$details->save();
		} else {
			// We need to create an order details object
			$details = $cart->orderDetails;
		}
		
		
		
		$details->subtotal = $this->totalItemCount($cart);
		$details->taxes = $this->taxesForProvinceCountryValue($province, $country, $details->subtotal);
		$details->shipping = $shipping_estimated_value;
		$details->shipping_type = $shipping_type;
		$details->save();
		
		
		
		
		
	}
	
	public function actionCheckout()
	{
		
		$country = Yii::app()->request->getPost("country", null);
		$province = Yii::app()->request->getPost("province", null);
		$postcode = Yii::app()->request->getPost("postcode", null);
		$shipment = Yii::app()->request->getPost("shipment", null);
		
		// Set the shipment in the session
		Yii::app()->session['shipment_method'] = $shipment;
		
		$cart = $this->getCart();
		
		if (!$cart || Yii::app()->user->isGuest){
			$this->redirect("/panier.html");
		}
		
		
		
		$this->render('checkout', array('subtotal'=>$this->subtotalForCart($cart), 'country'=>$country, "province"=>$province, "postcode"=>$postcode, 'shipment'=>$shipment, 'subtotal'=>$this->subtotalForCart($cart)));
		
	}

	public function actionIndex()
	{
		
		$this->breadcrumbs=array(
			Yii::t("app", 'Panier'),
		);
		
		$cart = $this->getCart();
		
		$dataProvider=new CActiveDataProvider('OrderHasProduct', array(
		    'criteria'=>array(
		        'condition'=>'order_id=' . $cart->id,
		        'with'=>array('product'),
		    ),
		    'pagination'=>false
		));
		
		
		$this->render('index', array("dataProvider"=>$dataProvider, 'subtotal'=>$this->subtotalForCart($cart), 'quantity'=>$dataProvider->totalItemCount));
	}
	
	/*
	 * Cart operations
	 */
	
	public function actionAdd()
	{
		$product = Product::model()->findByPk(Yii::app()->request->getPost('product'));
		$quantity = Yii::app()->request->getPost('quantity', "1");
		
		if ($product === null){
			throw new CHttpException(404,'Invalid product.');
		}
		
		$cart = $this->getCart();
		
		
		// Look for that existing product in the cart
		$item = OrderHasProduct::model()->findByPk(array('order_id' => $cart->id, 'product_id' => $product->id));
		if (!$item || $item === null){
			$item = new OrderHasProduct;
			$item->order_id = $cart->id;
			$item->product_id = $product->id;
			$item->quantity = $quantity;
		} else {
			$item->quantity = $quantity;
		}
		
		$item->price_paid = $product->price;
		
		
		if (!$item->save()){
			throw new CHttpException(400,'Error raised: ' . $item->getError());
		}
		
	}
	
	public function actionRemove()
	{
		
		$product = Yii::app()->request->getPost("product", null);
		$cart = $this->getCart();
		
		$orderHasProduct = OrderHasProduct::model()->findByPk(array('product_id'=>$product, 'order_id'=>$cart->id));
		
		
		if ($orderHasProduct === null){
			throw new CHttpException(400,'Your request is invalid.');
		}
		
		$orderHasProduct->delete();
		var_dump($orderHasProduct->getErrors());
	}
	
	public function actionUpdate()
	{
		$product = Yii::app()->request->getPost("product", null);
		$quantity = Yii::app()->request->getPost("quantity", null);
		$cart = $this->getCart();
		
		$orderHasProduct = OrderHasProduct::model()->findByPk(array('product_id'=>$product, 'order_id'=>$cart->id));
		
		
		
		if ($orderHasProduct === null){
			throw new CHttpException(400,'Your request is invalid.');
		}
		
		$orderHasProduct->quantity = $quantity;
		
		echo var_export($orderHasProduct);
		$orderHasProduct->save();
		
	}
	
	
	public function actionEstimate()
	{
		
		$country = Yii::app()->request->getPost("country", null);
		$province = Yii::app()->request->getPost("province", null);
		
		$postcode = Yii::app()->request->getPost("postcode", null);
		$email = Yii::app()->request->getPost("email", null);
		
		if ($country === null){
			throw new CHttpException(400,'Your request is invalid.');
		}
		
		$cart = $this->getCart();
		
		
		
		if (Yii::app()->user->isGuest){
			
			if ($email === null){
				// Cart is not registred to any user AND no email was provided.
				throw new CHttpException(400,'Your request is invalid.');
			}
			
			$validator=new CEmailValidator;
			if(!$validator->validateValue($email)){
			   throw new CHttpException(400,'Your request is invalid.');
			}
			
			
			$user = Yii::app()->user->createGuestUser($email);
			
		}
		
		Yii::app()->session['cart_country'] = $country;
		Yii::app()->session['cart_province'] = $province;
		
		if ($postcode){
			// Save the updated postcode
			Yii::app()->user->user->postcode = $postcode;
			Yii::app()->user->user->save();
		}
		
		$dataProvider=new CActiveDataProvider('OrderHasProduct', array(
		    'criteria'=>array(
		        'condition'=>'order_id=' . $cart->id,
		        'with'=>array('product'),
		    ),
		    'pagination'=>false,
		));
		
		$total_weight = 0.0;
		$total_value = 0.0;
		$total_item_qty = 0;
		foreach ($dataProvider->getData() as $relationship){
			$total_weight += $relationship->quantity * $relationship->product->weight;
			$total_value += $relationship->quantity * $relationship->price_paid;
			$total_item_qty += $relationship->quantity;
		}
		
		// Build the json request data we'll send to our server
		$weight = $total_weight;
		$handling = 0;
		$postal_code = $postcode;
		$country_code = $country;
		$value = $total_value;
		$qty = $total_item_qty;
		
		$orderData = array("weight"=>$weight, "handling"=>$handling, "postal_code"=>$postal_code, "country_code"=>$country_code, "value"=>$value, "qty"=>$qty, "locale"=>Yii::app()->language);
		
		
		$jsonpayload = json_encode($orderData);
		
		// Ping our main store cloud services bridge so the change is repercuted on all the client stores
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,            "https://kle-en-main.com/CloudServices/index.php/BoukemAPI/canadaPostEstimate/listServices?storeid=" . Yii::app()->params['outbound_api_user'] . "&storekey=" . Yii::app()->params['outbound_api_secret'] );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_POST,           1 );
		curl_setopt($ch, CURLOPT_POSTFIELDS,     $jsonpayload ); 
		curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json')); 
		$result=curl_exec ($ch);
		
		
		curl_close($ch);
		
		$arr = json_decode($result);
		
		if (!isset($arr->services)){
			throw new CHttpException(400,Yii::t('app', "Postes Canada ne peut fournir d'estimé en ce moment."));
		}
		$rates = $arr->services;
		
		if ($rates === null){
			throw new CHttpException(400,Yii::t('app', 'Une erreur est survenue.'));
		}
		
		$methods = $this->renderPartial('_estimate', array('methods'=>$rates), true);
		
		$outputdict = array("shipping_block"=>$methods);
		
		$outputdict['taxes'] = $this->taxesForProvinceCountryValue($province, $country, $total_value);
		
		$this->renderJSON($outputdict);
		
	}
	
	
	public function actionOrder()
	{

		$firstname = Yii::app()->request->getPost("firstname", null);
		$lastname = Yii::app()->request->getPost("lastname", null);
		$phone = Yii::app()->request->getPost("phone", null);
		
		$billing_addr1 = Yii::app()->request->getPost("billing_addr1", null);
		$billing_addr2 = Yii::app()->request->getPost('billing_addr2', null);
		$billing_city = Yii::app()->request->getPost('billing_city', null);
		$billing_region = Yii::app()->request->getPost('billing_region', null);
		$billing_postcode = Yii::app()->request->getPost('billing_postcode', null);
		$billing_country = Yii::app()->request->getPost('billing_country', null);
		$ship_to_billing = Yii::app()->request->getPost('ship_to_billing', null);
		if ($ship_to_billing === "true"){
			$shipping_addr1 = $billing_addr1;
			$shipping_addr2 = $billing_addr2;
			$shipping_city = $billing_city;
			$shipping_region = $billing_region;
			$shipping_postcode = $billing_postcode;
			$shipping_country = $billing_country;
			
		} else {
			$shipping_addr1 = Yii::app()->request->getPost("shipping_addr1", null);
			$shipping_addr2 = Yii::app()->request->getPost('shipping_addr2', null);
			$shipping_city = Yii::app()->request->getPost('shipping_city', null);
			$shipping_region = Yii::app()->request->getPost('shipping_region', null);
			$shipping_postcode = Yii::app()->request->getPost('shipping_postcode', null);
			$shipping_country = Yii::app()->request->getPost('shipping_country', null);
		}
		
		
		if (!$billing_addr1 || !$billing_city || !$billing_region || !$billing_postcode || !$billing_country || !$shipping_addr1 || !$shipping_city || !$shipping_region || !$shipping_postcode || !$shipping_country){
			throw new CHttpException(400,'Invalid request; missing parameters.');
			
		}
		
		if ((!Yii::app()->user->user->firstname && !$firstname) || (!Yii::app()->user->user->lastname && !$lastname)) {
			throw new CHttpException(400,'Invalid request; missing parameters for basic user info.');
			
		}
		
		if ($firstname){
			Yii::app()->user->user->firstname = $firstname;
			Yii::app()->user->user->save();
		}
		
		if ($lastname){
			Yii::app()->user->user->lastname = $lastname;
			Yii::app()->user->user->save();
		}
		
		$cart = $this->getCart();
		$order_details = $cart->orderDetails;
		if ($order_details === null){
			$order_details = new OrderDetails;
			$order_details->order_id = $cart->id;
		}
		
		// Save phone number
		Yii::app()->user->user->addUserPhone($phone);
		
		# TODO Replace systematic new addresses by saved addresses
		
		$billing_address = new Address;
		$billing_address->user_id = Yii::app()->user->user->id;
		$billing_address->street1 = $billing_addr1;
		$billing_address->street2 = $billing_addr2;
		$billing_address->city = $billing_city;
		$billing_address->postcode = $billing_postcode;
		$billing_address->region = $billing_region;
		$billing_address->country = $billing_country;
		$billing_address->save();
		
		$order_details->billing_address_id = $billing_address->id;
		
		if ($ship_to_billing === "true"){
			$shipping_address = $billing_address;
			$order_details->shipping_address_id = $billing_address->id;
		} else {
			$shipping_address = new Address;
			$shipping_address->user_id = Yii::app()->user->user->id;
			$shipping_address->street1 = $shipping_addr1;
			$shipping_address->street2 = $shipping_addr2;
			$shipping_address->city = $shipping_city;
			$shipping_address->postcode = $shipping_postcode;
			$shipping_address->region = $shipping_province;
			$shipping_address->country = $shipping_country;
			$shipping_address->save();
		
			$order_details->shipping_address_id = $shipping_address->id;
		}
		
		
		
		// Save every detail for the order total price and taxes based on the provided shipping address
		
		
		$itemsInCart=new CActiveDataProvider('OrderHasProduct', array(
		    'criteria'=>array(
		        'condition'=>'order_id=' . $cart->id,
		        'with'=>array('product'),
		    ),
		    'pagination'=>false
		));
		
		$total_weight = 0.0;
		$total_value = 0.0;
		$total_item_qty = 0;
		foreach ($itemsInCart->getData() as $relationship){
			$total_weight += $relationship->quantity * $relationship->product->weight;
			$total_value += $relationship->quantity * $relationship->price_paid;
			$total_item_qty += $relationship->quantity;
		}
		
		// Build the json request data we'll send to our server
		$weight = $total_weight;
		$handling = 0;
		$postal_code = $shipping_address->postcode;
		$country_code = $shipping_address->country;
		$value = $total_value;
		$qty = $total_item_qty;
		
		$orderData = array("weight"=>$weight, "handling"=>$handling, "postal_code"=>$postal_code, "country_code"=>$country_code, "value"=>$value, "qty"=>$qty);
		
		
		$jsonpayload = json_encode($orderData);
		
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,            "https://kle-en-main.com/CloudServices/index.php/MagentoBridge/canadaPostEstimate/listServices?storeid=" . Yii::app()->params['outbound_api_user'] . "&storekey=" . Yii::app()->params['outbound_api_secret'] );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_POST,           1 );
		curl_setopt($ch, CURLOPT_POSTFIELDS,     $jsonpayload ); 
		curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json')); 
		$result=curl_exec ($ch);
		
		curl_close($ch);
		
		$arr = json_decode($result);
		
		if (!isset($arr->services)){
			throw new CHttpException(400,Yii::t("app", "Postes Canada ne peut fournir d'estimé en ce moment."));
		}
		$rates = $arr->services;
		
		if ($rates === null){
			throw new CHttpException(400,Yii::t("app",'Une erreur est survenue.'));
		}
		
		
		$preferred_method = Yii::app()->session['shipment_method'];
		$shiprate = null;
		foreach ($rates as $rate) {
			
			if ($rate->service_code === $preferred_method){
				$shiprate = $rate->price_due;
				break;
			}
			
		}
		
		if ($shiprate === null){
			throw new CHttpException(400,'The delivery method specified in the cart is not available.');
		}
		
		// TAXES
		$order_details->shipping = $shiprate;
		$order_details->shipping_type = $preferred_method;
		
		$order_details->taxes = $this->taxesForProvinceCountryValue($shipping_address->region, $shipping_address->country, $total_value);
		$order_details->subtotal = $total_value;
		$order_details->total = floatval($order_details->subtotal) + floatval($order_details->taxes) + floatval($order_details->shipping);
		$order_details->balance = $order_details->total;
		
		$order_details->save();
		
		// Transform the cart in order to avoid deleting it.
		$cart->status = "pending";
		$cart->save();
		
		$order = $cart;
		$order->orderDetails = $order_details; // We need to manually set the association to avoid having a null returned
		
		$outputArray = array("id"=>$order->id, "verification_blob"=>$order->encryptedFrontendData(), 'sid'=>Yii::app()->params['outbound_api_user']);
		
		$this->renderJSON($outputArray);
	}
	
	public function actionConfirm($order){
		
		$model = Order::model()->findByPk($order);
		if ($model === null){
			throw new CHttpException(404,Yii::t('app', 'La page demandée n\'existe pas.'));
		}
		
		$this->render('confirm', array('model'=>$model));
		
	}
	
	public function actionOverview()
	{
		$cart = $this->getCart();
		
		
		$cache_id = Yii::app()->request->hostInfo . " CartController:[overviewForCart] " . $cart->id;
		$cache_duration = 10800;
	
		$output_array = Yii::app()->cache->get($cache_id);
		if (!$output_array){
			$dataProvider=new CActiveDataProvider('OrderHasProduct', array(
			    'criteria'=>array(
			        'condition'=>'order_id=' . $cart->id,
			        'with'=>array('product'),
			    ),
			    'pagination'=>false
			));
		
			$output_array = array();
			foreach ($dataProvider->getData() as $item){
				$cartitem = array(
					'quantity'=>$item->quantity,
					'price_paid'=>$item->price_paid,
					'product_id'=>$item->product_id,
				);
				$product = $item->product;
				$localization = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
				$image = $localization->getMainImage();
				$cartitem['name'] = $localization->name;
				$cartitem['slug'] = $localization->slug;
				$cartitem['thumbnail'] = $image ? $image->getImageURL(50, 50) : ProductImage::placehoderForSize(50, 50);
				$cartitem['link'] = $this->createUrl('Product/view', array('id'=>$product->id));
				$output_array[] = $cartitem;
			}
			
			Yii::app()->cache->set($cache_id, $output_array, $cache_duration);
			
		}
		$this->renderJSON($output_array);
		
		
	}
	
	
}