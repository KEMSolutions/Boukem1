<?php

/**
 * This is the model class for table "locale".
 *
 * The followings are the available columns in table 'locale':
 * @property string $id
 * @property string $Name
 * @property string $long_code
 *
 * The followings are the available model relations:
 * @property CategoryLocalization[] $categoryLocalizations
 * @property ProductImage[] $productImages
 * @property ProductLocalization[] $productLocalizations
 * @property User[] $users
 */
class Locale extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'locale';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, Name, long_code', 'required'),
			array('id', 'length', 'max'=>2),
			array('long_code', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, Name, long_code', 'safe', 'on'=>'search'),
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
			'categoryLocalizations' => array(self::HAS_MANY, 'CategoryLocalization', 'locale_id'),
			'productImages' => array(self::HAS_MANY, 'ProductImage', 'locale_id'),
			'productLocalizations' => array(self::HAS_MANY, 'ProductLocalization', 'locale_id'),
			'users' => array(self::HAS_MANY, 'User', 'locale_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'Name' => 'Name',
			'long_code' => 'Long Code',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('long_code',$this->long_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Locale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Returns a locale id for a specified long code.
	 * Used to exchange KEMConsole locale_id to Boukem's locale ids.
	 * @param string $long_code the long version of a locale identifier (eg. 'en_CA').
	 * @return str the small version of the same locale (eg. 'en'). Returns null if that locale is not supported.
	 */
	public static function localeIdFromLongCode($long_code){
			
			if ($long_code === "fr_CA"){
				return "fr";
			} else if ($long_code === "en_CA") {
				return "en";
			}
			
			return null;
	}
	
}
