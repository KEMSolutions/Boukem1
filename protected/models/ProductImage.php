<?php

/**
 * This is the model class for table "product_image".
 *
 * The followings are the available columns in table 'product_image':
 * @property integer $id
 * @property string $extension
 * @property integer $identifier
 * @property integer $product_id
 * @property integer $position
 * @property string $locale_id
 *
 * The followings are the available model relations:
 * @property Locale $locale
 * @property Product $product
 */
class ProductImage extends CActiveRecord
{
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('extension, identifier, product_id', 'required'),
			array('identifier, product_id, position', 'numerical', 'integerOnly'=>true),
			array('locale_id', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, extension, identifier, product_id, position, locale_id', 'safe', 'on'=>'search'),
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
			'locale' => array(self::BELONGS_TO, 'Locale', 'locale_id'),
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
			'extension' => 'Extension',
			'identifier' => 'Identifier',
			'product_id' => 'Product',
			'position' => 'Position',
			'locale_id' => 'Locale',
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
		$criteria->compare('extension',$this->extension,true);
		$criteria->compare('identifier',$this->identifier);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('position',$this->position);
		$criteria->compare('locale_id',$this->locale_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductImage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	
	/**
	 *  @return str specifies the base url of static images generator.
	 */
	public static function getImageGeneratorBaseUrl(){
		return "//static.boutiquekem.com/productimg-";
	}
	
	
	const FIT_AUTO = "auto";
	const FIT_WIDTH = "w";
	const FIT_HEIGHT = "h";
	
	/**
	 * Returns the appropriate url for the image with the provided width and height.
	 * @param int $width maximum width.
	 * @param int $height maximum height.
	 * @return str the image url (eg.: http://static.boutiquekem.com/img-1-2-3-4.png)
	 */
	public function getImageURL($width, $height, $fit=self::FIT_AUTO){
		
		
		
		
		if (rand(0, 1) || $fit != self::FIT_AUTO) {
			
			// OLD
			
			if ($width <= 300 && $height <= 280){
				// We can display thumbnails without the store's watermark. Cleaner for end users and easier on the server.
				$url = ProductImage::getImageGeneratorBaseUrl() . $width . "-" . $height . "-" . $this->identifier . ( $fit=== self::FIT_AUTO ? "" : "-" . $fit) . "." . $this->extension;
			} else {
				$url = ProductImage::getImageGeneratorBaseUrl() . Yii::app()->params['outbound_api_user'] . "-" . $width . "-" . $height . "-" . $this->identifier . ( $fit=== self::FIT_AUTO ? "" : "-" . $fit) . "." . $this->extension;
			}
			
		} else {
			
			$localization = $this->product->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
			
			// NEW
			$url = "https://img.kem.guru/product/" . Yii::app()->params['outbound_api_user'] . "/" . $width . "/" . $height . "/" . $this->identifier . "-" . ($localization ? $localization->slug : "product");
			
		}
		
		
		
		return $url;
		
		
	}
	
	
	/**
	 * Returns a placeholder image url with the specified size 
	 * @param int $width maximum width.
	 * @param int $height maximum height.
	 * @return str the image url (eg.: http://static.boutiquekem.com/img-1-2-3-0000.png)
	 */
	public static function placehoderForSize($width,$height)
	{
		
		if ($width <= 300 && $height <= 280){
			// We can display thumbnails without the store's watermark. Cleaner for end users and easier on the server.
			$url = ProductImage::getImageGeneratorBaseUrl() . $width . "-" . $height . "-0000.png";
		} else {
			$url = ProductImage::getImageGeneratorBaseUrl() . Yii::app()->params['outbound_api_user'] . "-" . $width . "-" . $height . "-0000.png";
		}
		
		
		
		return $url;
		
		
	}
	
}
