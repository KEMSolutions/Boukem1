<?php
/* @var $this SiteController */

$this->pageTitle = Yii::t('app', 'Retours et échanges') . ' - ' . Yii::app()->name;
$this->breadcrumbs=array(
	Yii::t('app', 'Retours et échanges'),
);
?>
<h1><?php echo Yii::t('app', 'Retours et échanges'); ?></h1>

<?php if (Yii::app()->language === "fr"): ?>
<p>Notre politique est de 30 jours. Si 30 jours se sont écoulés depuis la date d'expédition de votre commande, nous ne pouvons malheureusement pas vous proposer un remboursement ou un échange.</p> 

<p>Pour être admissible à un retour, votre article doit être inutilisé et dans le même état que vous l'avez reçu. Il doit également être dans l'emballage original. Notez bien que seuls les articles défectueux et / ou les commandes erronées, à notre seule discrétion, peuvent être remboursés ou échangés.<p> 

<p>Pour remplir votre déclaration, nous avons besoin d'un reçu ou une preuve d'achat.</p> 

<p>Ne retournez pas votre commande au magasin (s'il y a lieu) ou au manufacturier/fabricant. Prenez contact avec nous et nous nous occuperons de l'ensemble de la procédure de retour pour vous.</p> 

<p>Certaines situations ne vous rendent éligibles qu'à un remboursement partiel: (le cas échéant) <br /> 
Tout article non pas dans son état ​​d'origine, est endommagé ou les pièces manquantes pour des raisons non imputables à notre erreur. <br/> 
Tout article retourné plus de 30 jours après la livraison </p>
 
<p>Remboursements<br /> 
<b>Contactez nous avant de renvoyer un item pour fins de remboursement</b>. Vous trouverez l'adresse de courriel spécifique à votre commande sur le bordereau d'expédition inclus dans chaque envois de votre commande. Une fois votre retour reçu et inspecté, nous vous enverrons un courriel pour confirmer la réception de l'article retourné. Nous vous informerons également de l'approbation ou du rejet de votre remboursement.<br/> 
Si vous êtes approuvé, votre remboursement sera effectué, et un crédit sera automatiquement appliqué quelques jours plus tard à votre carte de crédit ou de la méthode de paiement d'origine.</p> 
<p>Remboursements en retard ou manquants (le cas échéant)<br/>
Si vous n'avez pas encore reçu un remboursement, prenez le temps de vérifier de nouveau votre compte bancaire/relevé de carte de crédit.<br /> 
Ensuite, communiquez avec votre compagnie de carte de crédit, il peut y avoir des délais considérables avant que votre remboursement soit officiellement affiché.<br/> 

Si après toutes ces vérifications vous n'avez toujours pas reçu votre remboursement, s'il vous plaît contactez-nous au support@boutiquekem.com.</p>
 <p> Articles en vente<br/> 
Tout comme les articles à prix régulier, les articles défectueux en vente, liquidation ou solde pourraient être remboursés après examen par nos services.</p>
<p>Échanges<br /> 
Nous remplaçons et remboursons seulement les articles s'ils sont défectueux ou endommagé, ou en cas d'erreur dans l'assemblage de votre commande. Si vous avez besoin d'un échange pour le même article, envoyez-nous un email à support@boutiquekem.com. Nous vous donnerons les instructions nécessaires à l'expédition du produit pour fins d'échange.</p> 

<p>Frais de port<br /> 
Pour retourner votre produit, vous devrez envoyer votre produit à: 5412 avenue du Parc Montréal Québec Canada H2V 4G7 </p>. 
<p> Vous serez responsable des frais de port pour renvoyer votre article si vous renvoyez l'article avant d'avoir pris entente avec nous. Même en cas de défectuosité ou d'erreur à votre commande, nous ne pourrons pas vous rembourser les frais de ports pour les articles renvoyés de votre propre initiative. <b>Bref, contactez nous avant de renvoyer un article afin que nous puissions vous envoyer une étiquette de retour</b>. 


<?php elseif (Yii::app()->language === "en"): ?>
	
	<p>Our policy lasts 30 days. If 30 days have gone by since your purchase shipping date, unfortunately we can’t offer you a refund or exchange.</p>
	
	<p>To be eligible for a return, your item must be unused and in the same condition that you received it. It must also be in the original packaging. Only defective items and / or mishandled order can be, at our sole discretion, refunded or exchanged.</p>
	
	<p>To complete your return, we require a receipt or proof of purchase.</p>
	
	<p>Please do not send your purchase back to the manufacturer.</p>
	
	<p>There are certain situations where only partial refunds are granted: (if applicable)<br />
	Any item not in its original condition, is damaged or missing parts for reasons not due to our error.<br />
	Any item that is returned more than 30 days after delivery</p>
	<p>Refunds (if applicable)<br />
	Once your return is received and inspected, we will send you an email to notify you that we have received your returned item. We will also notify you of the approval or rejection of your refund.<br />
	If you are approved, then your refund will be processed, and a credit will automatically be applied to your credit card or original method of payment, within a certain amount of days. </p>
	<p>Late or missing refunds (if applicable)<br />
	If you haven’t received a refund yet, first check your bank account again.<br />
	Then contact your credit card company, it may take some time before your refund is officially posted.<br />
	Next contact your bank. There is often some processing time before a refund is posted.<br />
	If you’ve done all of this and you still have not received your refund yet, please contact us at support@boutiquekem.com.</p>
	<p>Sale items (if applicable)<br />
	Just like regular priced items, defective items on sale could be refunded after review.</p>
	<p>Exchanges (if applicable)<br />
	We only replace and refund items if they are defective or damaged, or sent because of a mishandled order. If you need to exchange it for the same item, send us an email at support@boutiquekem.com and send your item to: 5412 Park Avenue Montreal Quebec Canada H2V 4G7.</p>

	<p>Shipping<br />
	To return your product, you should mail your product to: 5412 Park Avenue Montreal Quebec Canada H2V 4G7.</p>
	<p>You will be responsible for paying for your own shipping costs for returning your item unless we arrange a return with you prior to shipping. Therefore, we strongly suggest you contact us before shipping us back any item.</p>
	<p>Depending on where you live, the time it may take for your exchanged product to reach you, may vary.</p>
	<p>If you are shipping an item over $75, you should consider using a trackable shipping service or purchasing shipping insurance. We don’t guarantee that we will receive your returned item.</p>
	
<?php endif; ?>