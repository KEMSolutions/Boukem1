<?php

class WidgetController extends WebController
{
	
  /** Validates hex color, adding #-sign if not found.
   *   $color: the color hex value stirng to Validates
   */
	protected function validate_html_color($color) {
	  
  	  if (preg_match('/^#[a-f0-9]{6}$/i', $color)) {
	    // Verified OK, of type #00FF00
	  } else if (preg_match('/^[a-f0-9]{6}$/i', $color)) {
		  // Verified OK, of type 00FF00
	    $color = '#' . $color;
	  } else {
		  // Not a correct color. Return a flashy color so our user can notice.
		$color = "#000000";
	  }
	  
	  return $color;
	}
	

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
		
		$cache_id = "WidgetController:[promotionsForLanguage] " . md5(Yii::app()->language . CHtml::encode($background) . CHtml::encode($format) . " " . $limit . " " . $offset);
		$cache_duration = 120;//10800;
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
				
				if ($background != "transparent" && $background != "default") {
					$background = $this->validate_html_color($background);
				}
				
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