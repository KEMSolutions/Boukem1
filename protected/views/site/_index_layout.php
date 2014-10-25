<?php
	
$counter = 0;


foreach ($items as $slice){
	
	if ($slice->type === "slider"){
		/* We do not render the fraction slider, at least for now */
		//$this->renderPartial('_slider', array("items"=>$slice->items, 'show_title'=>$counter));
	} else if ($slice->type==="rebates"){
		
		$this->renderPartial('_rebates', array("items"=>$rebates, 'layout'=>$slice->content, 'show_tab'=>$counter));
		
	} else if ($slice->type === "mixed") {
		
		$this->renderPartial('_mixed', array("layout"=>$slice->content, 'show_tab'=>$counter));
		
	} else if ($slice->type === "featured") {
		
		$this->renderPartial('_featured', array("layout"=>$slice->content, 'show_tab'=>$counter));

	} else if ($slice->type === "headline"){
		$this->renderPartial('_headline', array("layout"=>$slice->content, 'show_tab'=>$counter));
	}
	
	$counter++;
	
}
	
?>
<section class="slice color-two product_history_box hidden" data-limit='4'> 
	<div class="section-title color-three">
	        <h3><?php echo Yii::t("app", "Articles récemment vus"); ?></h3>
	        <div class="indicator-down color-three"></div>
	    </div>
		<div class="product_history_box_content">
	<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i></div>
</div>
</section>
