<?php
/* @var $this CartController */

$this->pageTitle = Yii::t("app", "Panier");
$this->breadcrumbs = null;

$cart_is_empty = $dataProvider->totalItemCount < 1;
$this->layout = "//layouts/freestyle";

?>

		<?php
		
		// Register chosen script
		
		if ($cart_is_empty) {
			
		} else {
			
			$cs = Yii::app()->clientScript;
			$themePath = Yii::app()->theme->baseUrl;
		
			$login_url = $this->createUrl('site/login');
			$update_url = $this->createUrl('cart/update');
			$remove_url = $this->createUrl('cart/remove');
			$estimate_url = $this->createUrl('cart/estimate');
			$details_url = $this->createUrl('cart/details');
			$redeem_url = $this->createUrl('cart/redeem');
			$paypaltoken_url = $this->createUrl("cart/getPaypalToken");
			Yii::app()->user->returnUrl = $this->createUrl('index');
		
		
			$cs->registerScriptFile('/js/chosen.jquery.min.js',CClientScript::POS_END)
				
					
					    ->registerScript('estimate',
					        "
								var update_url = '$update_url';
								var remove_url = '$remove_url';
								var estimate_url = '$estimate_url';
								var details_url = '$details_url';
								var login_url = '$login_url';
								var redeem_url = '$redeem_url';
								var paypaltoken_url = '$paypaltoken_url';
							" ,CClientScript::POS_HEAD)
							->registerScriptFile('/js/boukem_cart.js',CClientScript::POS_END);
								
		
		
			if (Yii::app()->session['cart_country']){
				$cart_country = CJavaScript::quote(Yii::app()->session['cart_country']);
				$cart_province = CJavaScript::quote(Yii::app()->session['cart_province']);
			
				// A country was specified for the session, select if in the list with javascript
				$cs->registerScript('auto_fill_country',"$('#country').val('$cart_country'); $('#country').trigger('chosen:updated'); updateChosenSelects();", CClientScript::POS_READY);
			
			
				if (($cart_country === "CA" || $cart_country === "US" || $cart_country === "MX") && $cart_province) {
				
					$cs->registerScript('auto_fill_province',"$('#province').val('$cart_province'); $('#province').trigger('chosen:updated');", CClientScript::POS_READY);
				
				}
			
			
				if (Yii::app()->user->user->postcode && Yii::app()->user->user->postcode !== "" && $dataProvider->totalItemCount > 0){
				
					$cs->registerScript('auto_fetch_estimate',"fetchEstimate();", CClientScript::POS_READY);
				
				}
			
			}
		
		
			$cs->registerCssFile('/css/chosen.min.css');
		
		
		
			
			
		} // end of $cart_is_empty

		
			
		?>

<?php if ($cart_is_empty) : ?>
<section class="slice color-one">
    <div class="w-section inverse">
    	<div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aside-feature">
                        <div class="row">
                            
							 <div class="col-xs-12">
							<div class="text-center">
							                    	<h2><?php echo Yii::t("app", "Votre panier est vide."); ?></h2>
							                    	<h1 class="font-lg">
							                        	<i class="fa fa-shopping-cart"></i>                        </h1>
                        
							                        <span class="clearfix"></span>

							                    </div>
											</div>
							
							
                        </div>
                    </div>
                </div>
                

            </div>
        
        </div>
 	</div>  
                       
    
</section>



	

<section class="slice color-two product_history_box hidden" data-limit='4'> 
	<div class="section-title color-three">
	        <h3><?php echo Yii::t("app", "Articles récemment vus"); ?></h3>
	        <div class="indicator-down color-three"></div>
	    </div>
	<div class="product_history_box_content">
	<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i></div>
</div>
 
</section>


<?php else: ?>








<section class="cart-checkout">
	
	<div class="col-md-5 color-two cart-checkout-content">
		
		<div id="cart-items">
			<ul class="cart-items-list">            
			</ul>
		</div>
		
		<div class="cart-content-giftcard">
			
			<div class="input-group">
			      <input id="couponField" type="text" class="form-control input-sm" placeholder="<?php echo Yii::t("app", "Carte cadeau"); ?>" value="<?php echo Yii::app()->session['promocode']; ?>">
			      <span class="input-group-btn">
			        <button class="btn btn-sm btn-default" id="redeemCouponButton" type="button"><?php echo Yii::t("app", "Appliquer"); ?></button>
			      </span>
			    </div><!-- /input-group -->
		</div><!-- cart-content-giftcard -->
		
		<hr>
		<div class="cart-content-agreement">
		
		<p><?php echo Yii::t("app", "En cliquant sur le bouton acheter, continuer ou commander et/ou en visitant ce site, vous reconnaissez avoir lu et compris les conditions d'utilisation du site incluant, sans s'y limiter, la politique de confidentialité en vigueur. Si vous n'acceptez pas ces conditions, vous ne pouvez pas continuer à accéder à ce site.")?></p>
		
		</div>

	</div>
	
	<div class="col-md-7 cart-content-checkout-process">
		<form method="post" id="cart_form" class="<?php if ($dataProvider->totalItemCount == 0) {echo 'hidden'; } ?>">
		
		<div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading"><span class="badge pull-right">1</span><?php echo Yii::t('app', "Taxes et livraison"); ?></div>
			<div class="panel-body">
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
			
						<label for="country" class="control-label"><?php echo Yii::t('app', "Code Postal"); ?></label>
						<input type="text" name="postalcode" value="<?php echo (!Yii::app()->user->isGuest && Yii::app()->user->user->postcode) ? CHtml::encode(Yii::app()->user->user->postcode) : ''; ?>" placeholder="A1A 1A1" id="postcode" class="form-control">
					</div>
		
					<?php if (Yii::app()->user->isGuest): ?>
					<div class="form-group">
						<span class="hidden label label-info pull-right" id="why_email" data-toggle="tooltip" data-placement="left" data-trigger="click" title="<?php echo Yii::t('app', "Nous gardons votre courriel pour associer dès maintenant votre commande avec vos précédentes, appliquer les rabais associés à votre compte et vous permettre de retrouver votre panier. Nous ne vous enverrons aucun spam, aucune infolettre et nous ne vendrons pas votre courriel à des tiers."); ?>"><?php echo Yii::t('app', "Pourquoi?"); ?></span>
						<label for="customer_email" class="control-label"><?php echo Yii::t('app', "Adresse courriel / mail"); ?></label>
						<input type="email" name="email" id="customer_email" class="form-control" value="<?php //echo Yii::app()->user->user; ?>">
			
					</div>
				<?php endif; ?>
							
							<button class="btn btn-three pull-right btn-lg" id="estimateButton"><?php echo Yii::t('app', "Continuer"); ?></button>
				
			</div><!-- panel-body -->
		</div><!-- first panel -->
		
		
		
		<div class="panel panel-default hidden" id="estimate">
			
		</div><!-- second panel -->
		
		
		
		<div class="panel panel-default hidden" id="payment">
			
			<div class="panel-heading"><span class="badge pull-right">3</span><?php echo Yii::t('app', "Paiement sécurisé"); ?></div>
			
			
			<table class="table" id="finalPrice">
				
				<tr id="rebate_row" class="hidden">
					<td class="text-right" id="rebate_name"></td>
					<td id="rebate_value"></td>
				</tr>
				
			    <tr>
					<td width="75%" class="text-right"><?php echo Yii::t('app', "Sous-total"); ?></td>
					<td id="price_subtotal">0.00</td>
				</tr>
				<tr>
					<td class="text-right"><?php echo Yii::t('app', "Transport"); ?></td>
					<td id="price_transport">0.00</td>
				</tr>
				<tr>
				  <td class="text-right"><?php echo Yii::t('app', "Taxes"); ?></td>
				  <td id="price_taxes">0.00</td>
				</tr>
				<tr>
					<td class="text-right"><h4><?php echo Yii::t('app', "Total"); ?></h4></td>
					<td><h4 id="price_total">0.00</h4></td>
				</tr>
			
			</table>
			
			<div class="panel-body text-right">
				<button class="btn btn-three btn-lg" id="checkoutButton"><?php echo Yii::t('app', "Commander"); ?></button><br>
				<small class="hidden-xs">
					<i class="fa fa-lock"></i> <?php echo Yii::t("app", "Transaction sécurisée");?>
					<br>
					<i class="fa fa-cc-paypal"><span class="sr-only">Paypal</span></i>
					<i class="fa fa-cc-visa"><span class="sr-only">Visa</span></i>
					<i class="fa fa-cc-mastercard"><span class="sr-only">Mastercard</span></i>
					<i class="fa fa-cc-amex"><span class="sr-only">American Express</span></i>
					<i class="fa fa-cc-discover"><span class="sr-only">Discover</span></i>
				</small>
				
			</div><!-- panel-body -->
			
		</div><!-- third panel -->
		
		
		
	</form>
	</div>
	
</section>


<div class="clearfix"></div>

<?php endif; ?>