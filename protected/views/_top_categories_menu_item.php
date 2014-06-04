<?php /* @var $data Category */

$localization = CategoryLocalization::model()->find("category_id = :category AND locale_id = :locale", array(":category"=>$data->id, ":locale"=>Yii::app()->language));

if ($localization):
 ?>
<li><?php echo CHtml::link($localization->name,array('/category/view',
                                          'slug'=>$localization->slug)); ?></li>
										  
<?php endif; ?>