<?php
/* @var $this SiteController */

$this->pageTitle = Yii::t('app', 'À propos de la boutique') . ' - ' . Yii::app()->name;
$this->breadcrumbs=array(
	Yii::t('app', 'À propos de la boutique'),
);
?>
<h1><?php echo Yii::t('app', 'À propos de la boutique'); ?></h1>

<?php if (Yii::app()->language === "fr"): ?>
<p>Avec plus de 4000 produits de qualité, notre boutique virtuelle facilite vos achats en santé naturelle. Des marques professionnelles aux marques grand public, de l'homéopathie à l'aromathérapie, en passant par une vaste sélection de suppléments alimentaires, nul doute que vous trouverez sur ses pages l'essentiel pour une bonne santé.</p>

<p>Expédiant de notre entrepot de Montréal partout au Canada, notre riche catalogue peut bénéficier à l'ensemble de nos clients d'un océan à l'autre. Et même plus: notre service de livraison efficace, rapide et abordable ouvre la voie à l'international. Bref, de Montréal à Paris en passant par Moncton et Los Angeles, notre boutique virtuelle peut vous aider à rester en santé.</p>

<?php elseif (Yii::app()->language === "en"): ?>
	
	<p>With more than 4000 products for sale, our online store was built from the ground up with our customers in mind. With a large array of supplements and vitamins as well as professional grade brands, we can proudly offer customers one of the richest selection of natural health products in Canada.</p>
	
	<p>Shipping from our warehouse in Montreal (Canada), our clients are moslty located <em>ad mari usque ad mare</em> (from Sea to Sea). But with today's global economy and improving delivery services, more and more customers from all across the globe can benefit from our expertise and impressive catalog.</p>
	
<?php endif; ?>