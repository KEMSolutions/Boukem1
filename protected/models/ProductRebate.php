<?php

/**
 * This is the model class for table "product_rebate".
 *
 * The followings are the available columns in table 'product_rebate':
 * @property integer $id
 * @property integer $product_id
 * @property string $price
 * @property string $valid_from
 * @property string $valid_until
 *
 * The followings are the available model relations:
 * @property Product $product
 */
class ProductRebate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_rebate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, valid_from, valid_until', 'required'),
			array('product_id', 'numerical', 'integerOnly'=>true),
			array('price', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, price, valid_from, valid_until', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'price' => 'Price',
			'valid_from' => 'Valid From',
			'valid_until' => 'Valid Until',
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
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('valid_from',$this->valid_from,true);
		$criteria->compare('valid_until',$this->valid_until,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductRebate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public function beforeSave() {
	   	
		// Clean the public home page cache when we save a promotion, so the old price doesn't stay up many hours after a rebate ended
		$locales = Locale::model()->findAll();
		foreach ($locales as $locale){
			$cache_id = Yii::app()->request->hostInfo . " SiteController:[indexForLanguage] " . $locale->id;
			Yii::app()->cache->delete($cache_id);
		}
		
	    return parent::beforeSave();
	}
}
