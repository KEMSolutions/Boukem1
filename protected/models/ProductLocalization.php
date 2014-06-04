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
	
	
	
	// Elasticsearch stuff
	public $elasticType = 'product';
	
	/**
	 * Returns the behaviors for the record class.
	 * @return Array of behaviors (mostly there for adding elasticsearch)
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
	            'searchable' => array(
	                'class' => 'YiiElasticSearch\SearchableBehavior',
	            ),
	        );
	    }
		
	
	public $brand_name = null;
	public $brand_slug = null;
	public $image_id = null;
	
	/**
     * @param DocumentInterface $document the document where the indexable data must be applied to.
     */
	public function populateElasticDocument(YiiElasticSearch\Document $document)
	    {
	        $document->setId($this->id);
	        $document->name = $this->name;
	        $document->locale   = $this->locale_id;
		    $document->long_description = $this->long_description;
		    $document->short_description = $this->short_description;
			$document->slug = $this->slug;
			$document->visible = $this->visible;
			$document->product_id = $this->product_id;
			
			$brand = $this->product->brand;
			if ($brand){
				$brand_localized = $brand->localizationForLanguage(Yii::app()->language, $accept_substitute=true);
				$document->brand_name = $brand_localized->name;
				$document->brand_slug = $brand_localized->slug;
			}
			
			$main_image = $this->getMainImage();
			if ($main_image){
				$document->image_id = $this->getMainImage()->id;
			}
			
	}
	
	/**
	* @param DocumentInterface $document the document that is providing the data for this record.
	*/
	public function parseElasticDocument(YiiElasticSearch\Document $document)
	{
		// You should always set the match score from the result document
		
		if ($document instanceof SearchResult)
		    $this->setElasticScore($document->getScore());

		$this->id       = $document->getId();
		$this->name     = $document->name;
		$this->locale_id   = $document->locale;
	    $this->long_description = $document->long_description;
		$this->short_description = $document->short_description;
		$this->slug = $document->slug;
		$this->visible = $document->visible;
		
		if (isset($document->brand_name)){
			$this->brand_name = $document->brand_name;
			$this->brand_slug = $document->brand_slug;
		}
		
		$this->image_id = isset($document->image_id) ? $document->image_id : null;
		
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
