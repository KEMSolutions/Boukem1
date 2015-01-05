<?php

/**
 * This is the model class for table "category_localization".
 *
 * The followings are the available columns in table 'category_localization':
 * @property integer $id
 * @property string $locale_id
 * @property integer $category_id
 * @property string $name
 * @property integer $visible
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property Category $category
 * @property Locale $locale
 */
class CategoryLocalization extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category_localization';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('locale_id, category_id, name', 'required'),
			array('category_id, visible', 'numerical', 'integerOnly'=>true),
			array('locale_id', 'length', 'max'=>2),
			array('slug', 'length', 'max'=>1024),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, locale_id, category_id, name, visible', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
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
			'locale_id' => 'Locale',
			'category_id' => 'Category',
			'name' => 'Name',
			'visible' => 'Visible',
			'slug' => 'Slug',
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
		$criteria->compare('locale_id',$this->locale_id,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('visible',$this->visible);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CategoryLocalization the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
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
	            
	        );
	    }
		
	
	
	
}
