<?php
/* @var $this CartController */

$this->pageTitle = Yii::t("app", "Panier");
?>

<div class="table-responsive">
<table class="table table-striped">
<?php

 $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'emptyText'=>Yii::t("app", "Votre panier est vide."),
)); ?>
</table>
</div>

<form method="post" action="<?php echo $this->createUrl('cart/checkout'); ?>" id="cart_form">
<div class="panel panel-default">
  <div class="panel-heading"><?php echo Yii::t('app', "Taxes et livraison"); ?></div>
  <div class="panel-body">
    
	<div class="col-md-6">
	

		<?php
		
		// Register chosen script
		
		$cs = Yii::app()->clientScript;
		$themePath = Yii::app()->theme->baseUrl;
		
		$login_url = $this->createUrl('site/login');
		
		$update_url = $this->createUrl('cart/update');
		$estimate_url = $this->createUrl('cart/estimate');
		Yii::app()->user->returnUrl = $this->createUrl('index');
		
		
		$cs->registerScriptFile($themePath.'/assets/js/chosen.jquery.min.js',CClientScript::POS_END)

		    ->registerScript('chosen',
		        "$('select').chosen({});
					
					function updateChosenSelects() {
					
						var chosenCountry = $('#country').val();
						if (chosenCountry == 'CA' || chosenCountry == 'US'){
							$('#postcode').removeAttr('disabled');
							$('#province').removeAttr('disabled');
							$('#province').trigger('chosen:updated');
						} else {
							$('#province').attr('disabled','disabled');
							$('#postcode').attr('disabled');
						}
					
						$('#province optgroup').attr('disabled','disabled');
					
						if (chosenCountry == 'CA' || chosenCountry == 'US' || chosenCountry == 'MX'){
							$('#province [data-country=\"' + chosenCountry + '\"]').removeAttr('disabled');
						}
					
						$('#province').trigger('chosen:updated');
					}
					
				$('#country').chosen().change( function(){
					
					updateChosenSelects();
					
					} );"
		        ,CClientScript::POS_READY)
					
				    ->registerScript('estimate',
				        "function updateTotal(){
							var total_price = parseFloat($('#price_subtotal').text()) + parseFloat($('#price_transport').text()) + parseFloat($('#price_taxes').text());
							$('#price_total').text(total_price.toFixed(2));
						};
						
						var checkoutEnabled = false;
						function enableCheckout(){
							$('#estimateButton').removeClass('btn-primary');
							$('#estimateButton').addClass('btn-default');
							$('#checkoutButton').addClass('btn-primary');
							$('#checkoutButton').tooltip('disable');
							checkoutEnabled = true;
						}
						
						
						function fetchEstimate(){
							$('#estimate').html('<div class=\'text-center\'><i class=\"fa fa-spinner fa-3x fa-spin\"></i></div>');
							$.ajax({
							  type: 'POST',
							  dataType: 'json',
							  url: '$estimate_url',
							  data: {'country':$(\"#country\").val(), 'province':$(\"#province\").val(), 'postcode':$(\"#postcode\").val(),'email':$(\"#customer_email\").val()},
							  success: function(data){
								  
								  $('#estimate').html(data.shipping_block);
								  $('#price_taxes').text(data.taxes.toFixed(2));
								  
								  // Register the received radio buttons to trigger a total update
								  $(\".shipping_method\").change(function(){
									  	$('#price_transport').text($(this).attr('data-cost'));
										
										updateTotal();
										enableCheckout();
									  });
								  
							 },
							 error: function(xhr, textStatus){
								 
								 if (xhr.status == 403){
									 window.location.replace('$login_url');
									 return;
								 }
								 
								 $('#estimate').html('<div class=\"alert alert-danger\">Une erreur est survenue. Veuillez vérifier les informations fournies.</div>');
							 }
							  
							});
						}
						
						$('#estimateButton').click(function( event ){
							
							event.preventDefault();
							fetchEstimate();
							
						});
						"
				        ,CClientScript::POS_READY)
						    ->registerScript('checkout',
						        "$('#checkoutButton').click( function(event){
									
									
									if (!checkoutEnabled){
										event.preventDefault();
									}
									});"
						        ,CClientScript::POS_READY)
									
									->registerScript('update_quantity',
						        "$('.update_cart_quantity').click( function(){
										
										var row = $(this).closest('tr');
										var product_id = row.attr('data-product');
										var quantity = row.find('.quantity_field').val();
										
										$.post( '$update_url', { product: product_id, quantity: quantity })
										  .done(function( data ) {
										    location.reload();
										  });
										
										
									
									
									});"
						        ,CClientScript::POS_READY);
		
		
		if (Yii::app()->session['cart_country']){
			$cart_country = CJavaScript::quote(Yii::app()->session['cart_country']);
			$cart_province = CJavaScript::quote(Yii::app()->session['cart_province']);
			
			// A country was specified for the session, select if in the list with javascript
			$cs->registerScript('auto_fill_country',"$('#country').val('$cart_country'); $('#country').trigger('chosen:updated'); updateChosenSelects();", CClientScript::POS_READY);
			
			
			if (($cart_country === "CA" || $cart_country === "US" || $cart_country === "MX") && $cart_province) {
				
				$cs->registerScript('auto_fill_province',"$('#province').val('$cart_province'); $('#province').trigger('chosen:updated');", CClientScript::POS_READY);
				
			}
			
			
			if (Yii::app()->user->user->postcode && Yii::app()->user->user->postcode !== ""){
				
				$cs->registerScript('auto_fetch_estimate',"fetchEstimate();", CClientScript::POS_READY);
				
			}
			
		}
		
		
		$cs->registerCssFile($themePath.'/assets/css/chosen.min.css');
		
		
		
		
			
		?>
		
		<div class="form-group">
			<label for="country"><?php echo Yii::t('app', "Pays"); ?></label>
			<select id="country" name="country" class="form-control">
				<option value="AF">Afghanistan</option>
				<option value="AX">Åland Islands</option>
				<option value="AL">Albania</option>
				<option value="DZ">Algeria</option>
				<option value="AS">American Samoa</option>
				<option value="AD">Andorra</option>
				<option value="AO">Angola</option>
				<option value="AI">Anguilla</option>
				<option value="AQ">Antarctica</option>
				<option value="AG">Antigua and Barbuda</option>
				<option value="AR">Argentina</option>
				<option value="AM">Armenia</option>
				<option value="AW">Aruba</option>
				<option value="AU">Australia</option>
				<option value="AT">Austria</option>
				<option value="AZ">Azerbaijan</option>
				<option value="BS">Bahamas</option>
				<option value="BH">Bahrain</option>
				<option value="BD">Bangladesh</option>
				<option value="BB">Barbados</option>
				<option value="BY">Belarus</option>
				<option value="BE">Belgium</option>
				<option value="BZ">Belize</option>
				<option value="BJ">Benin</option>
				<option value="BM">Bermuda</option>
				<option value="BT">Bhutan</option>
				<option value="BO">Bolivia, Plurinational State of</option>
				<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
				<option value="BA">Bosnia and Herzegovina</option>
				<option value="BW">Botswana</option>
				<option value="BV">Bouvet Island</option>
				<option value="BR">Brazil</option>
				<option value="IO">British Indian Ocean Territory</option>
				<option value="BN">Brunei Darussalam</option>
				<option value="BG">Bulgaria</option>
				<option value="BF">Burkina Faso</option>
				<option value="BI">Burundi</option>
				<option value="KH">Cambodia</option>
				<option value="CM">Cameroon</option>
				<option value="CA"<?php if (!isset(Yii::app()->session['cart_country']) || Yii::app()->session['cart_country']) {echo ' selected'; } ?>>Canada</option>
				<option value="CV">Cape Verde</option>
				<option value="KY">Cayman Islands</option>
				<option value="CF">Central African Republic</option>
				<option value="TD">Chad</option>
				<option value="CL">Chile</option>
				<option value="CN">China</option>
				<option value="CX">Christmas Island</option>
				<option value="CC">Cocos (Keeling) Islands</option>
				<option value="CO">Colombia</option>
				<option value="KM">Comoros</option>
				<option value="CG">Congo</option>
				<option value="CD">Congo, the Democratic Republic of the</option>
				<option value="CK">Cook Islands</option>
				<option value="CR">Costa Rica</option>
				<option value="CI">Côte d'Ivoire</option>
				<option value="HR">Croatia</option>
				<option value="CU">Cuba</option>
				<option value="CW">Curaçao</option>
				<option value="CY">Cyprus</option>
				<option value="CZ">Czech Republic</option>
				<option value="DK">Denmark</option>
				<option value="DJ">Djibouti</option>
				<option value="DM">Dominica</option>
				<option value="DO">Dominican Republic</option>
				<option value="EC">Ecuador</option>
				<option value="EG">Egypt</option>
				<option value="SV">El Salvador</option>
				<option value="GQ">Equatorial Guinea</option>
				<option value="ER">Eritrea</option>
				<option value="EE">Estonia</option>
				<option value="ET">Ethiopia</option>
				<option value="FK">Falkland Islands (Malvinas)</option>
				<option value="FO">Faroe Islands</option>
				<option value="FJ">Fiji</option>
				<option value="FI">Finland</option>
				<option value="FR">France</option>
				<option value="GF">French Guiana</option>
				<option value="PF">French Polynesia</option>
				<option value="TF">French Southern Territories</option>
				<option value="GA">Gabon</option>
				<option value="GM">Gambia</option>
				<option value="GE">Georgia</option>
				<option value="DE">Germany</option>
				<option value="GH">Ghana</option>
				<option value="GI">Gibraltar</option>
				<option value="GR">Greece</option>
				<option value="GL">Greenland</option>
				<option value="GD">Grenada</option>
				<option value="GP">Guadeloupe</option>
				<option value="GU">Guam</option>
				<option value="GT">Guatemala</option>
				<option value="GG">Guernsey</option>
				<option value="GN">Guinea</option>
				<option value="GW">Guinea-Bissau</option>
				<option value="GY">Guyana</option>
				<option value="HT">Haiti</option>
				<option value="HM">Heard Island and McDonald Islands</option>
				<option value="VA">Holy See (Vatican City State)</option>
				<option value="HN">Honduras</option>
				<option value="HK">Hong Kong</option>
				<option value="HU">Hungary</option>
				<option value="IS">Iceland</option>
				<option value="IN">India</option>
				<option value="ID">Indonesia</option>
				<option value="IR">Iran, Islamic Republic of</option>
				<option value="IQ">Iraq</option>
				<option value="IE">Ireland</option>
				<option value="IM">Isle of Man</option>
				<option value="IL">Israel</option>
				<option value="IT">Italy</option>
				<option value="JM">Jamaica</option>
				<option value="JP">Japan</option>
				<option value="JE">Jersey</option>
				<option value="JO">Jordan</option>
				<option value="KZ">Kazakhstan</option>
				<option value="KE">Kenya</option>
				<option value="KI">Kiribati</option>
				<option value="KP">Korea, Democratic People's Republic of</option>
				<option value="KR">Korea, Republic of</option>
				<option value="KW">Kuwait</option>
				<option value="KG">Kyrgyzstan</option>
				<option value="LA">Lao People's Democratic Republic</option>
				<option value="LV">Latvia</option>
				<option value="LB">Lebanon</option>
				<option value="LS">Lesotho</option>
				<option value="LR">Liberia</option>
				<option value="LY">Libya</option>
				<option value="LI">Liechtenstein</option>
				<option value="LT">Lithuania</option>
				<option value="LU">Luxembourg</option>
				<option value="MO">Macao</option>
				<option value="MK">Macedonia, the former Yugoslav Republic of</option>
				<option value="MG">Madagascar</option>
				<option value="MW">Malawi</option>
				<option value="MY">Malaysia</option>
				<option value="MV">Maldives</option>
				<option value="ML">Mali</option>
				<option value="MT">Malta</option>
				<option value="MH">Marshall Islands</option>
				<option value="MQ">Martinique</option>
				<option value="MR">Mauritania</option>
				<option value="MU">Mauritius</option>
				<option value="YT">Mayotte</option>
				<option value="MX">Mexico</option>
				<option value="FM">Micronesia, Federated States of</option>
				<option value="MD">Moldova, Republic of</option>
				<option value="MC">Monaco</option>
				<option value="MN">Mongolia</option>
				<option value="ME">Montenegro</option>
				<option value="MS">Montserrat</option>
				<option value="MA">Morocco</option>
				<option value="MZ">Mozambique</option>
				<option value="MM">Myanmar</option>
				<option value="NA">Namibia</option>
				<option value="NR">Nauru</option>
				<option value="NP">Nepal</option>
				<option value="NL">Netherlands</option>
				<option value="NC">New Caledonia</option>
				<option value="NZ">New Zealand</option>
				<option value="NI">Nicaragua</option>
				<option value="NE">Niger</option>
				<option value="NG">Nigeria</option>
				<option value="NU">Niue</option>
				<option value="NF">Norfolk Island</option>
				<option value="MP">Northern Mariana Islands</option>
				<option value="NO">Norway</option>
				<option value="OM">Oman</option>
				<option value="PK">Pakistan</option>
				<option value="PW">Palau</option>
				<option value="PS">Palestinian Territory, Occupied</option>
				<option value="PA">Panama</option>
				<option value="PG">Papua New Guinea</option>
				<option value="PY">Paraguay</option>
				<option value="PE">Peru</option>
				<option value="PH">Philippines</option>
				<option value="PN">Pitcairn</option>
				<option value="PL">Poland</option>
				<option value="PT">Portugal</option>
				<option value="PR">Puerto Rico</option>
				<option value="QA">Qatar</option>
				<option value="RE">Réunion</option>
				<option value="RO">Romania</option>
				<option value="RU">Russian Federation</option>
				<option value="RW">Rwanda</option>
				<option value="BL">Saint Barthélemy</option>
				<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
				<option value="KN">Saint Kitts and Nevis</option>
				<option value="LC">Saint Lucia</option>
				<option value="MF">Saint Martin (French part)</option>
				<option value="PM">Saint Pierre and Miquelon</option>
				<option value="VC">Saint Vincent and the Grenadines</option>
				<option value="WS">Samoa</option>
				<option value="SM">San Marino</option>
				<option value="ST">Sao Tome and Principe</option>
				<option value="SA">Saudi Arabia</option>
				<option value="SN">Senegal</option>
				<option value="RS">Serbia</option>
				<option value="SC">Seychelles</option>
				<option value="SL">Sierra Leone</option>
				<option value="SG">Singapore</option>
				<option value="SX">Sint Maarten (Dutch part)</option>
				<option value="SK">Slovakia</option>
				<option value="SI">Slovenia</option>
				<option value="SB">Solomon Islands</option>
				<option value="SO">Somalia</option>
				<option value="ZA">South Africa</option>
				<option value="GS">South Georgia and the South Sandwich Islands</option>
				<option value="SS">South Sudan</option>
				<option value="ES">Spain</option>
				<option value="LK">Sri Lanka</option>
				<option value="SD">Sudan</option>
				<option value="SR">Suriname</option>
				<option value="SJ">Svalbard and Jan Mayen</option>
				<option value="SZ">Swaziland</option>
				<option value="SE">Sweden</option>
				<option value="CH">Switzerland</option>
				<option value="SY">Syrian Arab Republic</option>
				<option value="TW">Taiwan, Province of China</option>
				<option value="TJ">Tajikistan</option>
				<option value="TZ">Tanzania, United Republic of</option>
				<option value="TH">Thailand</option>
				<option value="TL">Timor-Leste</option>
				<option value="TG">Togo</option>
				<option value="TK">Tokelau</option>
				<option value="TO">Tonga</option>
				<option value="TT">Trinidad and Tobago</option>
				<option value="TN">Tunisia</option>
				<option value="TR">Turkey</option>
				<option value="TM">Turkmenistan</option>
				<option value="TC">Turks and Caicos Islands</option>
				<option value="TV">Tuvalu</option>
				<option value="UG">Uganda</option>
				<option value="UA">Ukraine</option>
				<option value="AE">United Arab Emirates</option>
				<option value="GB">United Kingdom</option>
				<option value="US">United States</option>
				<option value="UM">United States Minor Outlying Islands</option>
				<option value="UY">Uruguay</option>
				<option value="UZ">Uzbekistan</option>
				<option value="VU">Vanuatu</option>
				<option value="VE">Venezuela, Bolivarian Republic of</option>
				<option value="VN">Viet Nam</option>
				<option value="VG">Virgin Islands, British</option>
				<option value="VI">Virgin Islands, U.S.</option>
				<option value="WF">Wallis and Futuna</option>
				<option value="EH">Western Sahara</option>
				<option value="YE">Yemen</option>
				<option value="ZM">Zambia</option>
				<option value="ZW">Zimbabwe</option>
			</select>
		</div>

		<div class="form-group">
			<label for="province"><?php echo Yii::t('app', "Province/État/Région"); ?></label>
			<select id="province" name="province" class="form-control">
				 <optgroup data-country="CA" label="<?php echo Yii::t('app', "Provinces canadiennes"); ?>">
			<option value="AB">Alberta</option>
				<option value="BC">British Columbia</option>
				<option value="MB">Manitoba</option>
				<option value="NB">New Brunswick</option>
				<option value="NL">Newfoundland and Labrador</option>
				<option value="NS">Nova Scotia</option>
				<option value="ON">Ontario</option>
				<option value="PE">Prince Edward Island</option>
				<option value="QC"<?php if (!isset(Yii::app()->session['cart_province']) || Yii::app()->session['cart_province']) {echo ' selected'; } ?>>Quebec</option>
				<option value="SK">Saskatchewan</option>
				<option value="NT">Northwest Territories</option>
				<option value="NU">Nunavut</option>
				<option value="YT">Yukon</option>
			</optgroup>
				
				<optgroup data-country="US" label="<?php echo Yii::t('app', "États américains"); ?>">
					
					<option value="AL">Alabama</option>
						<option value="AK">Alaska</option>
						<option value="AZ">Arizona</option>
						<option value="AR">Arkansas</option>
						<option value="CA">California</option>
						<option value="CO">Colorado</option>
						<option value="CT">Connecticut</option>
						<option value="DE">Delaware</option>
						<option value="DC">District Of Columbia</option>
						<option value="FL">Florida</option>
						<option value="GA">Georgia</option>
						<option value="HI">Hawaii</option>
						<option value="ID">Idaho</option>
						<option value="IL">Illinois</option>
						<option value="IN">Indiana</option>
						<option value="IA">Iowa</option>
						<option value="KS">Kansas</option>
						<option value="KY">Kentucky</option>
						<option value="LA">Louisiana</option>
						<option value="ME">Maine</option>
						<option value="MD">Maryland</option>
						<option value="MA">Massachusetts</option>
						<option value="MI">Michigan</option>
						<option value="MN">Minnesota</option>
						<option value="MS">Mississippi</option>
						<option value="MO">Missouri</option>
						<option value="MT">Montana</option>
						<option value="NE">Nebraska</option>
						<option value="NV">Nevada</option>
						<option value="NH">New Hampshire</option>
						<option value="NJ">New Jersey</option>
						<option value="NM">New Mexico</option>
						<option value="NY">New York</option>
						<option value="NC">North Carolina</option>
						<option value="ND">North Dakota</option>
						<option value="OH">Ohio</option>
						<option value="OK">Oklahoma</option>
						<option value="OR">Oregon</option>
						<option value="PA">Pennsylvania</option>
						<option value="RI">Rhode Island</option>
						<option value="SC">South Carolina</option>
						<option value="SD">South Dakota</option>
						<option value="TN">Tennessee</option>
						<option value="TX">Texas</option>
						<option value="UT">Utah</option>
						<option value="VT">Vermont</option>
						<option value="VA">Virginia</option>
						<option value="WA">Washington</option>
						<option value="WV">West Virginia</option>
						<option value="WI">Wisconsin</option>
						<option value="WY">Wyoming</option>
					
				</optgroup>
				
				<optgroup data-country="MX" label="<?php echo Yii::t('app', "États mexicains"); ?>">
				<option value="DIF">Distrito Federal</option>
					<option value="AGS">Aguascalientes</option>
					<option value="BCN">Baja California</option>
					<option value="BCS">Baja California Sur</option>
					<option value="CAM">Campeche</option>
					<option value="CHP">Chiapas</option>
					<option value="CHI">Chihuahua</option>
					<option value="COA">Coahuila</option>
					<option value="COL">Colima</option>
					<option value="DUR">Durango</option>
					<option value="GTO">Guanajuato</option>
					<option value="GRO">Guerrero</option>
					<option value="HGO">Hidalgo</option>
					<option value="JAL">Jalisco</option>
					<option value="MEX">M&eacute;xico</option>
					<option value="MIC">Michoac&aacute;n</option>
					<option value="MOR">Morelos</option>
					<option value="NAY">Nayarit</option>
					<option value="NLE">Nuevo Le&oacute;n</option>
					<option value="OAX">Oaxaca</option>
					<option value="PUE">Puebla</option>
					<option value="QRO">Quer&eacute;taro</option>
					<option value="ROO">Quintana Roo</option>
					<option value="SLP">San Luis Potos&iacute;</option>
					<option value="SIN">Sinaloa</option>
					<option value="SON">Sonora</option>
					<option value="TAB">Tabasco</option>
					<option value="TAM">Tamaulipas</option>
					<option value="TLX">Tlaxcala</option>
					<option value="VER">Veracruz</option>
					<option value="YUC">Yucat&aacute;n</option>
					<option value="ZAC">Zacatecas</option>
				</optgroup>
				
				
			</select>
				
				
		</div>
		
		
		<div class="form-group">
			
			<label for="country"><?php echo Yii::t('app', "Code Postal"); ?></label>
			<input type="text" name="postcode" value="<?php echo (!Yii::app()->user->isGuest && Yii::app()->user->user->postcode) ? CHtml::encode(Yii::app()->user->user->postcode) : ''; ?>" placeholder="A1A 1A1" id="postcode" class="form-control">
		</div>
		
		<?php if (Yii::app()->user->isGuest): ?>
		<div class="form-group">
			
			<label for="customer_email"><?php echo Yii::t('app', "Adresse courriel / mail"); ?></label>
			<input type="text" name="email" id="customer_email" class="form-control" value="<?php //echo Yii::app()->user->user; ?>">
			
		</div>
	<?php endif; ?>
		
	
		
				<button class="btn btn-primary" id="estimateButton"><?php echo Yii::t('app', "Calculer les frais"); ?></button>
	
	</div>
	<div class="col-md-6">
	
		<div id="estimate">
		
		</div>
	
	<hr>
	<div id="finalPrice">
		
		<dl class="dl-horizontal">
		  <dt><?php echo Yii::t('app', "Sous-total"); ?></dt>
		  <dd id="price_subtotal"><?php echo $subtotal; ?></dd>
		  <dt><?php echo Yii::t('app', "Transport"); ?></dt>
		  <dd id="price_transport">0.00</dd>
		  <dt><?php echo Yii::t('app', "Taxes"); ?></dt>
		  <dd id="price_taxes">0.00</dd>
		  <dt><h4><?php echo Yii::t('app', "Total"); ?></h4></dt>
		  <dd><h4 id="price_total">0.00</h4></dd>
		</dl>
		
	</div>
	
	<div>
	<button class="btn btn-default pull-right btn-lg" id="checkoutButton" data-toggle="tooltip" data-placement="top" title="Entrez votre code postal pour calculer les taxes et frais de livraison."><?php echo Yii::t('app', "Commander"); ?></button>
</div>
	</div>
	
  </div>
</div>
</form>