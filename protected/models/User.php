<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $timestamp
 * @property string $email
 * @property string $password
 * @property string $firstname
 * @property string $lastname
 * @property string $verification_string
 * @property string $locale_id
 * @property string $postcode
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property Locale $locale
 * @property UserPhone[] $userPhones
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email', 'required'),
			array('email', 'length', 'max'=>254),
			array('email', 'email', 'allowEmpty'=>false, 'allowName'=>false, 'checkMX'=>true),
			array('email', 'unique'),
			array('locale_id', 'length', 'max'=>10),
			array('timestamp, password, firstname, lastname, verification_string, postcode', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, timestamp, email, password, firstname, lastname, verification_string, locale_id, postcode', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Order', 'user_id'),
			'locale' => array(self::BELONGS_TO, 'Locale', 'locale_id'),
			'userPhones' => array(self::HAS_MANY, 'UserPhone', 'user_id'),
			'addresses' => array(self::HAS_MANY, 'Address', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'timestamp' => 'Timestamp',
			'email' => 'Email',
			'password' => 'Password',
			'firstname' => 'Firstname',
			'lastname' => 'Lastname',
			'verification_string' => 'Verification String',
			'locale_id' => 'Locale',
			'postcode' => 'Postcode',
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
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('verification_string',$this->verification_string,true);
		$criteria->compare('locale_id',$this->locale_id,true);
		$criteria->compare('postcode',$this->postcode,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	/**
	 * Attempt to insert a new phone number for the user.
	 * Will try to avoid duplicates by searching for the normalized version of the phone number first.
	 * @param string $phone number you want to insert.
	 * @param boolean accepts_sms can this phone be used to receive SMS alerts?
	 * @return boolean true if the phone number was added succesffully, false if the phone number is invalid
	 */
	public function addUserPhone($phone, $accepts_sms=false){
		
		if ($phone === null){
			return false;
		}
		
		Yii::setPathOfAlias('libphonenumber',Yii::getPathOfAlias('application.vendor.libphonenumber'));
		$phonenumber=new libphonenumber\LibPhone($phone);
		
		
		if (!$phonenumber->validate()){
			return false;
		}
		
		$formatted_number = $phonenumber->toE164();
		
		$existing_phone = UserPhone::model()->find("user_id=:user_id AND number=:number", array(":user_id"=>$this->id, ":number"=>$formatted_number));
		
		
		if ($existing_phone !== null) {
			return true;
		}
		
		
		$userphone = new UserPhone;
		$userphone->user_id = $this->id;
		$userphone->number = $formatted_number;
		$userphone->sms_opt_in = $accepts_sms ? 1 : 0;
		$userphone->save();
		return true;
	}
	
}
