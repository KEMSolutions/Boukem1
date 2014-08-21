<?php
/* @var $this SiteController */

$this->pageTitle = Yii::t('app', 'Méthodes d\'expédition');

$country_script = <<<EOD
	
var gdpData = {
  "CA": 1,
  "US": 1,
  "FR": 1,
  "BE": 1,
  "MX": 1,
  "CH": 1,
  "DZ": 1,
  "MA": 1,
  "ES": 1,
  "DE": 1,
  "NL": 1,
  "GB": 1,
  "HT": 1,
  "IE": 1,
  "MG": 1,
  "NZ": 1,
  "AU": 1,
  "NC": 1,
  "ZA": 1,
  "AT": 1,
  "IT": 1,
  "PT": 1,
  "IS": 1,
  "FI": 1,
  "NO": 1,
  "SE": 1,
  "JP": 1,
  "IL": 1,
  "GR": 1,
  "HK": 1,
  "CL": 1
};
	
	
	
	$('#map').vectorMap({
		zoomOnScroll: false,
		map: 'world_mill_en',
		backgroundColor: 'transparent',
        regionStyle: {
              initial: {
                fill: '#8d8d8d'
              }
            },
		markerStyle: {
			      initial: {
			        fill: '#F8E23B',
			        stroke: '#383f47'
			      }
			    },
		markers: [
					{latLng: [45.5, -73.5667], name: 'Montréal'},
				],
		series: {
			            regions: [{
			              values: gdpData,
			              scale: ['#C8EEFF', '#0071A4'],
			              normalizeFunction: 'polynomial'
			            }]
			          },
		onMarkerLabelShow: function(e, label, code){
			        map.label.text(markersCoords[code].lat.toFixed(2)+', '+markersCoords[code].lng.toFixed(2));
			      }
		}// map
	);
EOD;

Yii::app()->clientScript->registerCssFile('/css/jquery-jvectormap-1.2.2.css');
Yii::app()->clientScript->registerScriptFile('//cdn.kem.guru/boukem/spirit/js/jquery-jvectormap-1.2.2.min.js');
Yii::app()->clientScript->registerScriptFile('//cdn.kem.guru/boukem/spirit/js/jquery-jvectormap-world-mill-en.js');
Yii::app()->clientScript->registerScript("shipping_world_map" , $country_script);

?>

<?php if (Yii::app()->language === "fr"): ?>
	
	<h2>Livraison au Canada</h2>
	
	<p>Notre fournisseur de livraison, Postes Canada, livrera vos colis d'un océan à l'autre rapidement et à peu de frais. Selon les disponibilités déterminées par Postes Canada, différents tarifs et modes de livraison vous seront offert à même votre panier, lors de votre commande.</p>
	
	<p class="text-center"><img src="/images/canadapost_logo.png" class="img-thumbnail" alt="Logo Postes Canada"></p>
	
	<p>Aussitôt votre commande reçue, notre équipe commencera à préparer celle-ci. Le temps de préparation peut varier: de 2 à 15 jours ouvrables selon le produit. Consultez la page de chaque produit pour connaître l'estimatif du temps de préparation.</p>
	
	
	<h2>Expédition internationale</h2>
<p>Nous pouvons expédier nos produits dans une sélection grandissante de pays: la disponibilité de notre réseau d'expédition est limité par notre processeur de paiement et notre service de livraison. Consultez la carte suivante pour connaître les endroits où nous pouvons à la fois expédier et livrer. Si votre pays n'apparaît pas dans la liste, contactez-nous pour connaître la disponibilité du service, la carte n'étant pas forcément toujours à jour.</p>


<?php elseif (Yii::app()->language === "en"): ?>
	
	<h2>Shipping to Canada</h2>
	
	<p>Our shipping carrier, Canada Post, will deliver (almost) everywhere you might be in Canada. Depending of your shipping address and availability, we will provide you with different deliver options at checkout.</p>
	
	<p class="text-center"><img src="/images/canadapost_logo.png" class="img-thumbnail" alt="Logo Postes Canada"></p>
	
	<p>Our team is proud to process orders as fast as possible. However, due to availability constraints, some product might take more time than others to prepare. Every product page provide you with a processing time estimate, varying between 2 and 15 days.</p> 
	
	<h2>International Shipping</h2>
	
	<p>We can ship our products in a growing list of countries around the World. However, there are still many places where our payment processor and/or shipping partner cannot do business. Check out the following map to know if you can do business with us. If your country is not yet marked in blue on the map, please contact us to know if shipping is available.</p>
	
<?php endif; ?>

<div id="map" style="height: 400px"></div>

<?php if (Yii::app()->language === "fr"): ?>
	
	<h2>Douanes et accise</h2>
<p>Lorsque vous commandez depuis l'étranger (soit l'extérieur du Canada), il importe de savoir que vous procédez à une importation dans votre pays d'origine. Il est à la charge du consommateur de connaître la législation en vigueur dans son pays afin de procéder à une importation dans les normes. Il est également à la charge du consommateur de s'assurer de payer les frais douaniers, taxes, etc. qui pourraient être imposées par les autorités postales et sur lesquelles nous n'avons évidemment aucun contrôle.</p>

<p>Lors de l'expédition, notre équipe remplira un manifeste (par exemple, les formulaires CN22 ou CN23) indiquant le contenu et la valeur de l'expédition. Sachez que certaines catégories de produits ne peuvent être importées légalement dans certaines législations, c'est votre devoir de vous assurer que les produits achetés peuvent traverser la douane de votre pays.


<?php elseif (Yii::app()->language === "en"): ?>
	
	<h2>Customs &amp; taxes</h2>
	<p>When ordering from outside of Canada, you're responsible for assuring the product can be lawfully imported to the destination country. The recipient is the importer of record and must comply with all laws and regulations of the destination country. Orders shipped outside of Canada may be subject to import taxes, customs duties and fees levied by the destination country. The recipient of an international shipment may be subject to such import taxes, customs duties and fees, which are levied once a shipment reaches the recipient's country. Additional charges for customs clearance must be borne by the recipient; we have no control over these charges and can't predict what they may be. Customs policies vary widely from country to country; you should contact your local customs office for more information. When customs clearance procedures are required, it can cause delays beyond our original delivery estimates.</p>

<p>We may provide certain order, shipment, and product information, such as titles, to our international carriers (by filling out a CN22 or CN23 manifest, for example), and such information may be communicated by the carriers to customs authorities in order to facilitate customs clearance and comply with local laws.</p>

<?php endif; ?>
