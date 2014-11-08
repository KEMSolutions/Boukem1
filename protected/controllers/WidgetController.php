<?php

class WidgetController extends WebController
{
	
	

	/**
	 * Currently reduced products
	 * When the output is set to iframe, styling will be added so the layout is self contained.
	 */
	public function actionRebates($format="html", $limit=4)
	{
		
		
		
		$cache_id = Yii::app()->request->hostInfo . " WidgetController:[promotionsForLanguage] " . Yii::app()->language . $format . $limit;
		$cache_duration = 10;//10800;
		$content = Yii::app()->cache->get($cache_id);
		
		if (!$content) {
			$rebatesDataProvider=new CActiveDataProvider('ProductRebate', array(
				'criteria'=>array(
					'limit'=>$limit,
				    'with'=>array('product', 'product.productLocalization'),
			), 'pagination'=>false,));
			
			if ($format === "html"){
				$content = $this->renderPartial('_rebates', array('rebates'=>$rebatesDataProvider), true);
			} else {
				$content = array();
			}
				
			Yii::app()->cache->set($cache_id, $content, $cache_duration);
		}
		
		if ($format === "html") {
			echo $content;
		} else {
			throw new CHttpException(404,'The format parameter is invalid.');
		}
		
		
	}

	
}