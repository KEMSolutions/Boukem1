<?php
$rebates_array = $rebates->getData();
shuffle($rebates_array);

?><!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
<head>
	<link href="/css/boukem_widget.css" rel="stylesheet" media="all" type="text/css" />
</head>
<body><div class="container-fluid">
<div class="row">
	<ul class="list-unstyled">
<?php foreach ($rebates_array as $rebate){
	$product = $rebate->product;
	$localization = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=false);
	if ($product && $localization && $product->visible && !$product->discontinued){
		$this->renderPartial("_widget_product_card", array("product"=>$product, "localization"=>$localization));
	}
}
?></ul></div></div>
</body>
</html>