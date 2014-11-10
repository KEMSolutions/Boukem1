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
	public function actionRebates($format="html", $limit=4, $offset=0, $background="default", $version=1, $pretty=0)
	{
		
		if (!is_numeric($limit) || !is_numeric($offset) || !is_numeric($version) || !is_numeric($pretty)){
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
			} else if ($format === "json"){
				
				$content = array();
				
				foreach ($rebatesDataProvider->getData() as $rebate){
					
					$product = $rebate->product;
					$localization = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=false);
					if ($product && $localization && $product->visible && !$product->discontinued){
						
						$product_url = $this->createAbsoluteUrl("product/view", array('slug'=>$localization->slug));
						
						$currentPrice = $product->getCurrentPrice();
						$regularPrice = $product->price;
						if ($currentPrice == $regularPrice) {
							$isOnSale = false;
							$rebatePercent = 0;
						} else {
							$isOnSale = true;
							$rebatePercent = round((($regularPrice - $currentPrice) / $regularPrice) * 100, $precision=0, $mode=PHP_ROUND_HALF_DOWN);
						}
						
						
						// Assemble a dictionary with the values
						$main_image = $localization->getMainImage();
						$image_dict = array();
						if ($main_image){
							$image_dict["thumbnail_50"] = $main_image->getImageUrl(50, 50);
							$image_dict["thumbnail_250"] = $main_image->getImageUrl(250, 250);
							$image_dict["thumbnail_500"] = $main_image->getImageUrl(500, 500);
							$image_dict["thumbnail_1000"] = $main_image->getImageUrl(1000, 1000);
							$image_dict["is_placeholder"] = false;
						} else {
							$image_dict["thumbnail_50"] = ProductImage::placehoderForSize(50, 50);
							$image_dict["thumbnail_250"] = ProductImage::placehoderForSize(250, 250);
							$image_dict["thumbnail_350"] = ProductImage::placehoderForSize(350, 350);
							$image_dict["thumbnail_500"] = ProductImage::placehoderForSize(500, 500);
							$image_dict["thumbnail_1000"] = ProductImage::placehoderForSize(1000, 1000);
							$image_dict["is_placeholder"] = true;
						}
						
						$product_dict = array(
							"id"=>$product->id,
							"image"=>$image_dict,
							"name"=>$localization->name,
							"description"=>$localization->short_description,
							"url"=>$product_url,
							"current_price"=>$currentPrice,
							"regular_price"=>$regularPrice,
							"is_on_sale"=>$isOnSale,
							"rebate_percent"=>$rebatePercent,
						);
						
						$content[] = $product_dict;
						
					}
					
				}
				
				
			} else {
				$content = array();
			}
				
			Yii::app()->cache->set($cache_id, $content, $cache_duration);
		}
		
		if ($format === "html") {
			echo $content;
		} else if ($format === "json") {
			header('Access-Control-Allow-Origin: *');
			$this->renderJson($content, $pretty=$pretty);
		} else {
			throw new CHttpException(400,'The format parameter is invalid.');
		}
		
		
	}

	
}