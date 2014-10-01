<?php
	
foreach ($items as $type => $slice){
	
	if ($type === "slider"){
		$this->renderPartial('_slider', array("items"=>$slice->items));
	} else if ($type==="rebates"){
		
		$this->renderPartial('_rebates', array("items"=>$rebates, 'style'=>'normal', 'limit'=>4));
		
	} else if ($type === "recommended") {
		
		$this->renderPartial('_recommended', array("items"=>$slice));
		
	} else if ($type === "promoted") {
		$this->renderPartial('_featured', array("items"=>$slice->products, 'style'=>'normal', 'limit'=>8));
	}
	
	
}
	
?>
<section class="slice color-two product_history_box hidden" data-limit='4'> 
	<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i></div>
</section>
