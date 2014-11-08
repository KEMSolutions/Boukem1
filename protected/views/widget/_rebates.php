<?php
$rebates_array = $rebates->getData();
shuffle($rebates_array);

?><!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
<head>
	<meta charset="utf-8">
	<meta name="referrer" content="default" id="meta_referrer" />
	<meta name="robots" content="noindex">
	<link href="/css/boukem_widget.css" rel="stylesheet" media="all" type="text/css" />
	<?php
	if ($background === "default"){
		echo "<style>html {background:#f2f2f2}</style>";
	} else {
		echo "<style>.card {box-shadow: 0 -1px 30px rgba(0, 0, 0, 0.15);}</style>";
	}
?>
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