<?php

/**
 * This is the model class for table "order_details".
 *
 * The followings are the available columns in table 'order_details':
 * @property integer $order_id
 * @property string $subtotal
 * @property string $taxes
 * @property string $total
 * @property string $shipping
 * @property string $shipping_type
 * @property integer $billing_address_id
 * @property integer $shipping_address_id
 * @property string $balance
 *
 * The followings are the available model relations:
 * @property Address $shippingAddress
 * @property Order $order
 * @property Address $billingAddress
 */
class OrderDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, shipping_type', 'required'),
			array('order_id, billing_address_id, shipping_address_id', 'numerical', 'integerOnly'=>true),
			array('subtotal, taxes, total, shipping, balance', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('order_id, subtotal, taxes, total, shipping, shipping_type, billing_address_id, shipping_address_id, balance', 'safe', 'on'=>'search'),
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
			'shippingAddress' => array(self::BELONGS_TO, 'Address', 'shipping_address_id'),
			'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
			'billingAddress' => array(self::BELONGS_TO, 'Address', 'billing_address_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'order_id' => 'Order',
			'subtotal' => 'Subtotal',
			'taxes' => 'Taxes',
			'total' => 'Total',
			'shipping' => 'Shipping',
			'shipping_type' => 'Shipping Type',
			'billing_address_id' => 'Billing Address',
			'shipping_address_id' => 'Shipping Address',
			'balance' => 'Balance',
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

		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('subtotal',$this->subtotal,true);
		$criteria->compare('taxes',$this->taxes,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('shipping',$this->shipping,true);
		$criteria->compare('shipping_type',$this->shipping_type,true);
		$criteria->compare('billing_address_id',$this->billing_address_id);
		$criteria->compare('shipping_address_id',$this->shipping_address_id);
		$criteria->compare('balance',$this->balance,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
