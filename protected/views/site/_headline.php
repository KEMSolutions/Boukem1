<?php
$language = Yii::app()->language;
$locale = $language . "_CA";
?>
<section id="homepageCarousel" class="carousel carousel-1 home_headline slide <?php if (!isset($layout->background) && $layout->style === "dark"){
	echo "color-one";
} else {
	echo "color-two";
}
?>">
<?php
if ($show_tab){
	$this->renderPartial('_tab', array("layout"=>$layout));
}
?>
    <div class="carousel-inner">
    	<div class="item item-<?php echo CHtml::encode($layout->style); ?> active"<?php
			if (isset($layout->background) && $layout->background->type == "image" && $layout->background->url !== ""){
				echo ' style="background-image:url(' . CHtml::encode($layout->background->url) . ')"';
			}
			 ?>>
            <div class="container">
                <div class="description fluid-center">
                	<?php
						$title_variable_name = "title_" . $locale;
						 if (isset($layout->$title_variable_name)) {
							 echo '<span class="title">' . CHtml::encode($layout->$title_variable_name) . '</span>';
						 } ?>
						 
						 
	                 	<?php
	 						$subtitle_variable_name = "subtitle_" . $locale;
	 						 if (isset($layout->$subtitle_variable_name)) {
	 							 echo '<span class="subtitle">' . CHtml::encode($layout->$subtitle_variable_name) . '</span>';
	 					} ?>
                    
                    
                </div>
        	</div>
    	</div>
    </div>
</section>