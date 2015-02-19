<?php

class CssController extends WebController
{
	
	protected function adjustBrightness($hex, $steps) {
	    // Steps should be between -255 and 255. Negative = darker, positive = lighter
	    $steps = max(-255, min(255, $steps));

	    // Normalize into a six character long hex string
	    $hex = str_replace('#', '', $hex);
	    if (strlen($hex) == 3) {
	        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
	    }

	    // Split into three parts: R, G and B
	    $color_parts = str_split($hex, 2);
	    $return = '#';

	    foreach ($color_parts as $color) {
	        $color   = hexdec($color); // Convert to decimal
	        $color   = max(0,min(255,$color + $steps)); // Adjust color
	        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
	    }

	    return $return;
	}
	
	protected function getCssFilesList(){
		
		$themePath = Yii::app()->theme->baseUrl;
		$main_style_sheet = '/css/global-style.css';
		if (file_exists(Yii::app()->basePath . "/.." . $themePath . $main_style_sheet)){
			$main_style_sheet = $themePath . $main_style_sheet;
		}

		$secondary_style_sheet = '/css/skin-four.css';
		if (file_exists(Yii::app()->basePath . "/.." . $themePath . $secondary_style_sheet)){
			$secondary_style_sheet = $themePath . $secondary_style_sheet;
		}
		
		
		$cssFiles = array(
		Yii::app()->basePath . "/../" . $main_style_sheet,
		Yii::app()->basePath . "/../" . $secondary_style_sheet,
		Yii::app()->basePath . "/../css/cart-drawer.css",
		);
		return $cssFiles;
	}

	/**
	 * Mash up our css and replace some values when custom values are available on KEM Console.
	 */
	public function actionCustom()
	{
		
		$cache_id = "CustomBoukemCss";
		$cache_duration = 3600;
		
		$customCss = Yii::app()->cache->get($cache_id);
		
		if (!$customCss){
			
			$request_parameters = array('storeid'=>Yii::app()->params['outbound_api_user'], 'storekey'=>Yii::app()->params['outbound_api_secret']);
			$output = Yii::app()->curl->get("https://kle-en-main.com/CloudServices/index.php/BoukemAPI/colors/index", $request_parameters);
			
			$base_dict = json_decode($output);
			
			// Concatenate all customizable css files
			$buffer = "";
			foreach ($this->getCssFilesList() as $cssFile) {
			  $buffer .= file_get_contents($cssFile);
			}

			// Remove comments
			$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

			// Remove space after colons
			$buffer = str_replace(': ', ':', $buffer);
			
			if (isset($base_dict->color_one)){
				$buffer = str_replace('#f0523f', '#' . $base_dict->color_one, $buffer);
				$buffer = str_replace('#e06d58', $this->adjustBrightness($base_dict->color_one, -45), $buffer);
				$buffer = str_replace('#dc402e', $this->adjustBrightness($base_dict->color_one, -75), $buffer);
			}
			
			if (isset($base_dict->color_two)){
				$buffer = str_replace('#2d93ff', '#' . $base_dict->color_two, $buffer);
				$buffer = str_replace('#7a92ac', $this->adjustBrightness($base_dict->color_two, -75), $buffer);
				
			}
			
			if (isset($base_dict->color_three)){
				$buffer = str_replace('#ecebec', '#' . $base_dict->color_three, $buffer);
				$buffer = str_replace('#f2f2f2', $this->adjustBrightness($base_dict->color_three, +25), $buffer);
				
			}
			
			if (isset($base_dict->color_four)){
				$buffer = str_replace('#2d2d2d', '#' . $base_dict->color_four, $buffer);
			}
			
			if (isset($base_dict->color_five)){
				$buffer = str_replace('#4c4c4c', '#' . $base_dict->color_five, $buffer);
				$buffer = str_replace('#777', $this->adjustBrightness($base_dict->color_five, -75), $buffer);
				$buffer = str_replace('#999', $this->adjustBrightness($base_dict->color_five, +95), $buffer);
				$buffer = str_replace('#ccc', $this->adjustBrightness($base_dict->color_five, 75), $buffer);
				$buffer = str_replace('#31363a', $this->adjustBrightness($base_dict->color_five, -150), $buffer);
			}
			
			if (isset($base_dict->injected)){
				$buffer .= $base_dict->injected;
			}
			
			$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
			
			Yii::app()->cache->set($cache_id, $customCss, $cache_duration);
		}
		
		
		ob_start("ob_gzhandler");

		// Enable caching
		header('Cache-Control: public');

		// Expire in one day
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $cache_duration) . ' GMT');

		// Set the correct MIME type, because Apache won't set it for us
		header("Content-type: text/css");

		// Write everything out
		echo($buffer);
		
	    foreach (Yii::app()->log->routes as $route) {
	        if($route instanceof CWebLogRoute) {
	            $route->enabled = false; // disable any weblogroutes
	        }
	    }
	    Yii::app()->end();
	}

	
}