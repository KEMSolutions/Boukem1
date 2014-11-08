<?php

class WidgetController extends WebController
{
	
	

	/**
	 * Currently reduced products
	 * When the output is set to iframe, styling will be added so the layout is self contained.
	 */
	public function actionRebates($format="html", $limit=4, $offset=0, $background="default", $version=1)
	{
		
		if (!is_numeric($limit) || !is_numeric($offset) || !is_numeric($version)){
			throw new CHttpException(400,'A numeric value was expected.');
		}
		
		if ($limit > 32 || $offset > 32) {
			throw new CHttpException(400,'Offset and limit can\'t be larger than 32. If you need to retrieve a large amount of products efficiently, please refer to Boukem\'s API documentation.');
		}
		
		$cache_id = Yii::app()->request->hostInfo . " WidgetController:[promotionsForLanguage] " . Yii::app()->language . $format . " " . $limit . " " . $offset;
		$cache_duration = 10;//10800;
		$content = Yii::app()->cache->get($cache_id);
		
		if (!$content) {
			$rebatesDataProvider=new CActiveDataProvider('ProductRebate', array(
				'criteria'=>array(
					'order'=>"valid_until",
					'limit'=>$limit,
					'offset'=>$offset,
					
				    'with'=>array('product', 'product.productLocalization'),
			), 'pagination'=>false,));
			
			if ($format === "html"){
				$content = $this->renderPartial('_rebates', array('rebates'=>$rebatesDataProvider, "background"=>$background), true);
			} else {
				$content = array();
			}
				
			Yii::app()->cache->set($cache_id, $content, $cache_duration);
		}
		
		if ($format === "html") {
			echo $content;
		} else {
			throw new CHttpException(400,'The format parameter is invalid.');
		}
		
		
	}

	
}