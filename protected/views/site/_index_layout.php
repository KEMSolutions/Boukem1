<?php
	
$counter = 0;
foreach ($items as $type => $slice){
	
	if ($type === "slider"){
		/* We do not render the fraction slider, at least for now */
		//$this->renderPartial('_slider', array("items"=>$slice->items, 'show_title'=>$counter));
	} else if ($type==="rebates"){
		
		$this->renderPartial('_rebates', array("items"=>$rebates, 'style'=>'normal', 'limit'=>4, 'show_title'=>$counter));
		
	} else if ($type === "recommended") {
		
		$this->renderPartial('_recommended', array("items"=>$slice, 'show_title'=>$counter));
		
	} else if ($type === "promoted") {
		$this->renderPartial('_featured', array("items"=>$slice->products, 'style'=>'normal', 'limit'=>8, 'show_title'=>$counter, 'style'=>"fs"));
	} else if ($type === "headline"){
		$this->renderPartial('_headline', array("headline"=>$slice, 'show_title'=>$counter));
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
