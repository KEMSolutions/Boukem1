<?php

/**
 * This is the model class for table "product_localization".
 *
 * The followings are the available columns in table 'product_localization':
 * @property integer $id
 * @property integer $product_id
 * @property string $locale_id
 * @property string $name
 * @property string $long_description
 * @property string $short_description
 * @property integer $visible
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property Locale $locale
 */
class ProductLocalization extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_localization';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, locale_id, name, long_description, short_description', 'required'),
			array('locale_id', 'length', 'max'=>2),
			array('product_id, visible', 'numerical', 'integerOnly'=>true),
			array('slug', 'length', 'max'=>1024),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, locale_id, name, long_description, short_description, visible, slug', 'safe', 'on'=>'search'),
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
			'locale' => array(self::BELONGS_TO, 'Locale', 'locale_id'),
		);
	}

    public  function scopes()
    {
        return array(
            'locale'=>array(
                'condition'=>'locale_id="' . Yii::app()->language . '"',
            ),
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
			'locale_id' => 'Locale',
			'name' => 'Name',
			'long_description' => 'Long Description',
			'short_description' => 'Short Description',
			'visible' => 'Visible',
			'slug' => 'Url Key',
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
		$criteria->compare('locale_id',$this->locale_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('long_description',$this->long_description,true);
		$criteria->compare('short_description',$this->short_description,true);
		$criteria->compare('visible',$this->visible);
		$criteria->compare('slug',$this->slug,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductLocalization the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public $image_id;
	
	/**
	 * Returns the behaviors for the record class.
	 * @return Array of behaviors (mostly there for adding sluggable)
	 */
	public function behaviors()
	    {
	        return array(
				'sluggable' => array(
				      'class'=>'ext.behaviors.SluggableBehavior.SluggableBehavior',
				      'columns' => array('locale_id', 'name'),
				      'unique' => true,
				      'update' => true,
				),
	            
	        );
	    }
		
	
	
	
	/**
	 * Returns the main image for the localization, another localization if none exists, or null if the product has absolutely no image.
	 * @return ProductImage main image for localization
	 */
	public function getMainImage() {
		
		if ($this->image_id){
			$productimage = ProductImage::model()->findByPk($this->image_id);
			if ($productimage)
				return $productimage;
		}
		
		$params = array(
			'order'=>'position',
			'condition'=>'product_id=:product_id',
			'params'=>array(':product_id'=>$this->product_id)
		);
			
		
		$productimage = ProductImage::model()->find($params);
		
		
		
		return $productimage;
	}
	
}
