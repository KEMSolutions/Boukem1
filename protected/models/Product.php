<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $sku
 * @property string $barcode
 * @property integer $brand_id
 * @property integer $discontinued
 * @property integer $visible
 * @property integer $taxable
 * @property string $price
 * @property string $weight
 * @property integer $parent_product_id
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property Category $brand
 * @property Product $parentProduct
 * @property Product[] $products
 * @property Category[] $categories
 * @property ProductImage[] $productImages
 * @property ProductLocalization[] $productLocalizations
 * @property ProductRebate[] $productRebates
 */
class Product extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sku, brand_id', 'required'),
			array('brand_id, discontinued, visible, taxable, parent_product_id', 'numerical', 'integerOnly'=>true),
			array('barcode', 'length', 'max'=>64),
			array('price, weight', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sku, barcode, brand_id, discontinued, visible, taxable, price, weight, parent_product_id', 'safe', 'on'=>'search'),
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
			'orders' => array(self::MANY_MANY, 'Order', 'order_has_product(product_id, order_id)'),
			'brand' => array(self::BELONGS_TO, 'Category', 'brand_id'),
			'parentProduct' => array(self::BELONGS_TO, 'Product', 'parent_product_id'),
			'products' => array(self::HAS_MANY, 'Product', 'parent_product_id'),
			'categories' => array(self::MANY_MANY, 'Category', 'product_has_category(product_id, category_id)'),
			'productImages' => array(self::HAS_MANY, 'ProductImage', 'product_id'),
			'productLocalizations' => array(self::HAS_MANY, 'ProductLocalization', 'product_id'),
			'productRebates' => array(self::HAS_MANY, 'ProductRebate', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sku' => 'Sku',
			'barcode' => 'Barcode',
			'brand_id' => 'Brand',
			'discontinued' => 'Discontinued',
			'visible' => 'Visible',
			'taxable' => 'Taxable',
			'price' => 'Price',
			'weight' => 'Weight',
			'parent_product_id' => 'Parent Product',
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
		$criteria->compare('sku',$this->sku,true);
		$criteria->compare('barcode',$this->barcode,true);
		$criteria->compare('brand_id',$this->brand_id);
		$criteria->compare('discontinued',$this->discontinued);
		$criteria->compare('visible',$this->visible);
		$criteria->compare('taxable',$this->taxable);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('parent_product_id',$this->parent_product_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	/**
	 * Returns a localization for the specified product and language.
	 * @param string $language The two letter locale id for the language.
	 * @param boolean $accept_substitute if true, will return any other localization in lieu if the one asked is unavailable.
	 * @return ProductLocalization the static model class
	 */
	public function localizationForLanguage($language, $accept_substitute=false){
		if ($this->_localizationForLanguage !== null){
			return $this->_localizationForLanguage;
		}
		$criteria = new CDbCriteria;  
		$criteria->addCondition('product_id=' . $this->id);
		$criteria->addCondition('locale_id="' . $language .'"');
		$localizationForProduct = ProductLocalization::model()->find($criteria);

		if ($localizationForProduct===null && $accept_substitute){
			// No localization exists for the current page localization. User might have added the product from a page in another language than switched language. Just pick the first localization available for the product and call it a day.
			$localizationForProduct = array_shift(array_values($this->productLocalizations));
		}
		
		$this->_localizationForLanguage = $localizationForProduct;
		return $localizationForProduct;
	}
	private $_localizationForLanguage = null;
	
}
