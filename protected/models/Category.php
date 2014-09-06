<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property integer $parent_category
 * @property integer $visible
 * @property integer $is_brand
 *
 * The followings are the available model relations:
 * @property Category $parentCategory
 * @property Category[] $children
 * @property CategoryLocalization[] $categoryLocalizations
 * @property Product[] $products
 * @property Product[] $branded_products
 */
class Category extends CActiveRecord
{
	public $restrictScopeToCurrentLocale = true;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_category, visible, is_brand', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_category, visible, is_brand', 'safe', 'on'=>'search'),
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
			'parentCategory' => array(self::BELONGS_TO, 'Category', 'parent_category'),
			'children' => array(self::HAS_MANY, 'Category', 'parent_category'),
			'categoryLocalizations' => array(self::HAS_MANY, 'CategoryLocalization', 'category_id'),
			'categoryLocalization' => array(self::HAS_ONE, 'CategoryLocalization', 'category_id', 'scopes' => array('locale'), 'joinType' => 'INNER JOIN'),
			'branded_products' => array(self::HAS_MANY, 'Product', 'brand_id'),
			'products' => array(self::MANY_MANY, 'Product', 'product_has_category(category_id, product_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_category' => 'Parent Category',
			'visible' => 'Visible',
			'is_brand' => 'Is Brand',
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
		$criteria->compare('parent_category',$this->parent_category);
		$criteria->compare('visible',$this->visible);
		$criteria->compare('is_brand',$this->is_brand);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
	public function searchChildren()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		
		
		
        $criteria->compare('parent_category' , $this->id);
		$criteria->compare('t.visible',$this->visible);
		
		if ($this->restrictScopeToCurrentLocale){
			$criteria->with = array('categoryLocalization');
			$criteria->order = "categoryLocalization.name ASC";
			
		}
		
		
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	/**
	 * Returns a localization for the specified category and language.
	 * @param string $language The two letter locale id for the language.
	 * @param boolean $accept_substitute if true, will return any other localization in lieu if the one asked is unavailable.
	 * @return CategoryLocalization the localized category
	 */
	public function localizationForLanguage($language, $accept_substitute=false){
		if ($this->_localizationForLanguage !== null){
			return $this->_localizationForLanguage;
		}
		
		$criteria = new CDbCriteria;  
		$criteria->addCondition('category_id=' . $this->id);
		$criteria->addCondition('locale_id="' . $language .'"');
		$localizationForCategory = CategoryLocalization::model()->find($criteria);

		if ($localizationForCategory===null && $accept_substitute){
			// No localization exists for the current page localization. User might have added the product from a page in another language than switched language. Just pick the first localization available for the product and call it a day.
			$localizationForCategory = array_shift(array_values($this->categoryLocalizations));
		}
		
		$this->_localizationForLanguage = $localizationForCategory;
		return $localizationForCategory;
	}
	public $_localizationForLanguage = null;
	
}
