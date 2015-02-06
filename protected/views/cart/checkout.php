<?php
/* @var $this CartController */

// Register chosen script

$cs = Yii::app()->clientScript;
$themePath = Yii::app()->theme->baseUrl;
$cs->registerCssFile('/css/chosen.min.css');
$cs->registerCssFile($themePath.'/css/process.css');

$pageLocale = Yii::app()->language;
$this->pageTitle = Yii::t("app", "Adresse et informations de commande");

$cart_order_url = $this->createUrl("order");

$cs
    ->registerScriptFile('/js/chosen.jquery.min.js',CClientScript::POS_END)

    ->registerScript('chosen',
        "$('select').chosen({});
			
			$('#billing_country').change(function(event){
				var country = $('#billing_country').val();
				if (country != 'CA' && country != 'US' && country != 'MX'){
					$('#billing_region').attr('disabled', 'disabled').trigger('chosen:updated');
				} else {
					$('#billing_region').removeAttr('disabled').trigger('chosen:updated');
				}
			});
			
			$('#shipping_country').change(function(event){
				var country = $('#shipping_country').val();
				if (country != 'CA' && country != 'US' && country != 'MX'){
					$('#shipping_region').attr('disabled', 'disabled').trigger('chosen:updated');
				} else {
					$('#shipping_region').removeAttr('disabled').trigger('chosen:updated');
				}
			});
			
			
			"
        ,CClientScript::POS_READY);

		if ($province){
			$sanitized_province = CHtml::encode($province);
			$cs->registerScript('prefilled_province', "$('.province').val(\"$sanitized_province\").change().trigger('chosen:updated');",CClientScript::POS_READY);
		}
		
		if ($country){
			$sanitized_country = CHtml::encode($country);
			$cs->registerScript('prefilled_country', "$('.country').val(\"$sanitized_country\").change().trigger('chosen:updated');",CClientScript::POS_READY);
		}
		
		if ($postcode){
			$post_code = CHtml::encode($postcode);
			$cs->registerScript('prefilled_postcode', "$('.postcode').val(\"$post_code\");",CClientScript::POS_READY);
		}
		
		$cs->registerScript('checkout_general', "
			
			var ship_to_billing = 'true';
			
			$('#delivery_address').hide();
			$('[name=\"useSameAddress\"]').change(function(){
				$('#delivery_address').toggle('fast');
					
					// Add a 'required' attribute to all delivery fields when we don't use the same address
					if ($(this).val()=='false'){
						$('[id^=shipping_]').not('#shipping_addr2').not('#shipping_region').attr('required', 'required');
						ship_to_billing = 'false';
					} else {
						$('[id^=shipping_]').removeAttr('required');
						ship_to_billing = 'true';
					} 
					
				})
				
				
				
			$('#checkout_submit_button').click(function(event){
				
				event.preventDefault();
				// Check that mandatory fields are there
				
				// Empty all preexisting errors
				$('.has-error').removeClass('has-error');
				$('.alert-danger').hide();
				
				var passedValidation = true;
				$(':input[required]').each(function(index){
					
					if (!$(this).val() || !$(this).val().length){
						$(this).closest('.form-group').addClass('has-error');
						passedValidation = false;
					}
					
					})
				
				if (passedValidation) {
					
					$('#checkout_submit_button').html('<i class=\"fa fa-spinner fa-3x fa-spin\"></i>');
					$('#checkout_submit_button').attr('disabled', 'disabled');
					$.ajax({
					  type: 'POST',
					  dataType: 'json',
					  url: '$cart_order_url',
					  data: {
						  'firstname' : $('#fname') ? $('#fname').val() : null,
						  'lastname' : $('#lname') ? $('#lname').val() : null,
						  'phone' : $('#phone') ? $('#phone').val() : null,
						  'billing_addr1' : $('#billing_addr1').val(),
						  'billing_addr2' : $('#billing_addr2').val(),
						  'billing_city' : $('#billing_city').val(),
						  'billing_region' : $('#billing_region').val(),
						  'billing_postcode' : $('#billing_postcode').val(),
						  'billing_country' : $('#billing_country').val(),
						  'ship_to_billing' : ship_to_billing,
						  'shipping_addr1' : $('#shipping_addr1').val(),
						  'shipping_addr2' : $('#shipping_addr2').val(),
						  'shipping_city' : $('#shipping_city').val(),
						  'shipping_region' : $('#shipping_region').val(),
						  'shipping_postcode' : $('#shipping_postcode').val(),
						  'shipping_country' : $('#shipping_country').val()
						  },
					  success: function(data){
						  
						  
						  /*
						  $('<form>', {
						      'id': 'submitToPaymentPortal',
						      'html': '<input type=\"text\" name=\"order_id\" value=\"' + data.id + '\" /><input type=\"text\" name=\"sid\" value=\"' + data.sid + '\" /><input type=\"text\" name=\"verification_blob\" value=\"' + data.verification_blob + '\" /><input type=\"text\" name=\"locale\" value=\"$pageLocale\" />',
						      'action': 'https://kem.guru/secure/payment',
							  'method':'post'
						  }).appendTo(document.body).submit();
						  */
						  
					 },
					 error: function(data, textStatus){
						 window.alert(textStatus);
					 }
					 });
					
					
					
				
				} else {
					$('#incomplete_form_alert').removeClass('hide');
					$('#incomplete_form_alert').fadeIn('fast');
					} // end of passedValidation
				
				
			
			});
			
			
			");

?>


<div class="col-xs-12">
		
        
            <div class="row bs-wizard" style="border-bottom:0;">
                
                <div class="col-xs-4 bs-wizard-step complete">
                  <div class="text-center bs-wizard-stepnum"><?php echo Yii::t('app', 'Étape {step}',
    array('{step}'=>"1")); ?></div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center"><?php echo Yii::t('app', 'Panier et mode de livraison'); ?></div>
                </div>
                
                <div class="col-xs-4 bs-wizard-step"><!-- complete -->
                  <div class="text-center bs-wizard-stepnum"><?php echo Yii::t('app', 'Étape {step}',
    array('{step}'=>"2")); ?></div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center"><?php echo Yii::t('app', 'Adresse et informations de commande'); ?></div>
                </div>
                
                <div class="col-xs-4 bs-wizard-step disabled"><!-- active -->
                  <div class="text-center bs-wizard-stepnum"><?php echo Yii::t('app', 'Étape {step}',
    array('{step}'=>"3")); ?></div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#" class="bs-wizard-dot"></a>
                  <div class="bs-wizard-info text-center"><?php echo Yii::t('app', 'Paiement sécurisé'); ?></div>
                </div>
				
            </div>
        
        
        
        
        
	</div>



    <div class="col-xs-12">
      <form class="form-horizontal" role="form" method="POST">
		  
		  <?php if (!Yii::app()->user->user->firstname || !Yii::app()->user->user->lastname || count(Yii::app()->user->user->userPhones) > 0): ?>
          <fieldset>

            <!-- Form Name -->
            <legend class="title"><?php echo Yii::t('app', 'À propos de vous'); ?></legend>

<?php if (!Yii::app()->user->user->firstname): ?>
            <!-- Text input-->
            <div class="form-group">
              <label class="col-sm-2 control-label" for="fname" ><?php echo Yii::t('app', 'Prénom'); ?></label>
              <div class="col-sm-10">
                <input type="text" name="fname" placeholder="<?php echo Yii::t('app', 'Prénom'); ?>" id="fname" class="form-control" x-autocompletetype="section-billing given-name" required>
              </div>
            </div>
<?php endif; // firstname ?>

<?php if (!Yii::app()->user->user->lastname): ?>
            <!-- Text input-->
            <div class="form-group">
              <label class="col-sm-2 control-label" for="lname"><?php echo Yii::t('app', 'Nom'); ?></label>
              <div class="col-sm-10">
                <input type="text" name="lname" placeholder="<?php echo Yii::t('app', 'Nom'); ?>" id="lname" class="form-control" x-autocompletetype="section-billing surname" required>
              </div>
            </div>
<?php endif; // lastname ?>
			

<?php if (count(Yii::app()->user->user->userPhones) === 0): ?>
            <!-- Text input-->
            <div class="form-group">
              <label class="col-sm-2 control-label" for="phone"><?php echo Yii::t('app', 'Téléphone'); ?></label>
              <div class="col-sm-10">
                <input type="tel" name="phone" placeholder="1 (555) 555-1234" id="phone" class="form-control" x-autocompletetype="section-billing phone-national" required>
              </div>
            </div>
<?php endif; // telephone ?>
			
		</fieldset>
		  <?php endif; ?>
		  
        <fieldset>

          <!-- Form Name -->
          <legend class="title"><?php echo Yii::t('app', 'Adresse de facturation'); ?></legend>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="billing_addr1"><?php echo Yii::t('app', 'Adresse ligne 1'); ?></label>
            <div class="col-sm-10">
              <input required type="text" name="billing_addr1" id="billing_addr1" placeholder="<?php echo Yii::t('app', 'Adresse ligne 1'); ?>" class="form-control" x-autocompletetype="section-billing address-line1">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="billing_addr2"><?php echo Yii::t('app', 'Adresse ligne 2'); ?></label>
            <div class="col-sm-10">
              <input type="text" name="billing_addr2" id="billing_addr2" placeholder="<?php echo Yii::t('app', 'Adresse ligne 2'); ?>" class="form-control" x-autocompletetype="section-billing address-line2">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="billing_city"><?php echo Yii::t('app', 'Ville'); ?></label>
            <div class="col-sm-10">
              <input type="text" required name="billing_city" id="billing_city" placeholder="<?php echo Yii::t('app', 'Ville'); ?>" class="form-control" x-autocompletetype="section-billing city">
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="billing_region"><?php echo Yii::t('app', 'Province/État/Région'); ?></label>
            <div class="col-sm-4">
				
  			<select name="billing_region" id="billing_region" class="province form-control" x-autocompletetype="section-billing region">
  				 <optgroup data-country="CA" label="<?php echo Yii::t('app', 'Provinces canadiennes'); ?>">
  			<option value="AB">Alberta</option>
  				<option value="BC">British Columbia</option>
  				<option value="MB">Manitoba</option>
  				<option value="NB">New Brunswick</option>
  				<option value="NL">Newfoundland and Labrador</option>
  				<option value="NS">Nova Scotia</option>
  				<option value="ON">Ontario</option>
  				<option value="PE">Prince Edward Island</option>
  				<option value="QC" selected>Quebec</option>
  				<option value="SK">Saskatchewan</option>
  				<option value="NT">Northwest Territories</option>
  				<option value="NU">Nunavut</option>
  				<option value="YT">Yukon</option>
  			</optgroup>
				
  				<optgroup data-country="US" label="<?php echo Yii::t('app', 'États américains'); ?>">
					
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
				
  				<optgroup data-country="MX" label="<?php echo Yii::t('app', 'États mexicains'); ?>">
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

            <label class="col-sm-2 control-label" for="billing_postcode"><?php echo Yii::t('app', 'Code Postal'); ?></label>
            <div class="col-sm-4">
              <input type="text" name="billing_postcode" id="billing_postcode" required placeholder="<?php echo Yii::t('app', 'Code Postal'); ?>" class="form-control postcode" x-autocompletetype="section-billing postal-code">
            </div>
          </div>



          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="billing_country"><?php echo Yii::t('app', 'Pays'); ?></label>
            <div class="col-sm-10">
  			<select name="billing_country" required id="billing_country" class="country form-control" x-autocompletetype="section-billing country">
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
  				<option value="CA">Canada</option>
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
          </div>
		  
        </fieldset>
		
        <fieldset>

          <!-- Form Name -->
          <legend class="title"><?php echo Yii::t('app', "Adresse de livraison"); ?></legend>
		
        <!-- Text input-->
        <div class="form-group">
          <div class="col-sm-12">
            
			<div class="radio">
			  <label>
			    <input type="radio" name="useSameAddress" value="true" checked>
			    <?php echo Yii::t('app', "Utiliser l'adresse de facturation pour la livraison."); ?>
			  </label>
			</div>
			<div class="radio">
			  <label>
			    <input type="radio" name="useSameAddress" value="false">
				<?php echo Yii::t('app', "Livrer à une adresse différente."); ?>
			    
			  </label>
			</div>
			
          </div>
        </div>
		
		
		<div id="delivery_address">
            <!-- Text input-->
            <div class="form-group">
              <label class="col-sm-2 control-label" for="shipping_addr1"><?php echo Yii::t('app', "Adresse ligne 1"); ?></label>
              <div class="col-sm-10">
                <input type="text" name="shipping_addr1" id="shipping_addr1" placeholder="<?php echo Yii::t('app', "Adresse ligne 1"); ?>" class="form-control" x-autocompletetype="section-shipping address-line1">
              </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
              <label class="col-sm-2 control-label" for="shipping_addr2"><?php echo Yii::t('app', "Adresse ligne 2"); ?></label>
              <div class="col-sm-10">
                <input type="text" name="shipping_addr2" id="shipping_addr2" placeholder="<?php echo Yii::t('app', "Adresse ligne 2"); ?>" class="form-control" x-autocompletetype="section-shipping address-line2">
              </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
              <label class="col-sm-2 control-label" for="shipping_city"><?php echo Yii::t('app', "City"); ?></label>
              <div class="col-sm-10">
                <input type="text" name="shipping_city" id="shipping_city" placeholder="<?php echo Yii::t('app', "Ville"); ?>" class="form-control" x-autocompletetype="section-shipping city">
              </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
              <label class="col-sm-2 control-label" for="shipping_region"><?php echo Yii::t('app', "Province/État/Région"); ?></label>
              <div class="col-sm-4">
				
    			<select name="shipping_region" id="shipping_region" class="province form-control" x-autocompletetype="section-shipping region">
    				 <optgroup data-country="CA" label="<?php echo Yii::t('app', "Provinces canadiennes"); ?>">
    			<option value="AB">Alberta</option>
    				<option value="BC">British Columbia</option>
    				<option value="MB">Manitoba</option>
    				<option value="NB">New Brunswick</option>
    				<option value="NL">Newfoundland and Labrador</option>
    				<option value="NS">Nova Scotia</option>
    				<option value="ON">Ontario</option>
    				<option value="PE">Prince Edward Island</option>
    				<option value="QC" selected>Quebec</option>
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

              <label class="col-sm-2 control-label" for="shipping_postcode"><?php echo Yii::t('app', "Code Postal"); ?></label>
              <div class="col-sm-4">
                <input type="text" name="shipping_postcode" id="shipping_postcode" placeholder="<?php echo Yii::t('app', "Code Postal"); ?>" class="form-control postcode" x-autocompletetype="section-shipping postal-code">
              </div>
            </div>



            <!-- Text input-->
            <div class="form-group">
              <label class="col-sm-2 control-label" for="shipping_country"><?php echo Yii::t('app', "Country"); ?></label>
              <div class="col-sm-10">
    			<select name="shipping_country" id="shipping_country" class="country form-control" x-autocompletetype="section-shipping country">
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
    				<option value="CA">Canada</option>
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
            </div>
           
		</div>
		
		
		</fieldset>
		<div class="alert alert-danger hide" id="incomplete_form_alert"><strong><?php echo Yii::t('app', "Votre formulaire est incomplet."); ?></strong> <?php echo Yii::t('app', "Certains champs obligatoires ne sont pas correctement remplis. Retournez dans le formulaire et renseignez ces champs avant de soumettre à nouveau le formulaire."); ?></div>
		
		<div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="pull-right">
                <button type="submit" class="btn btn-three" id="checkout_submit_button"><i class="fa fa-lock"></i> <?php echo Yii::t('app', "Poursuivre vers le paiement sécurisé"); ?></button>
				
              </div>
			  
            </div>
          </div>
		  
		  
		  
      </form>
    </div><!-- /.col-lg-12 -->


