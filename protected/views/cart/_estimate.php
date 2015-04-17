<div class="panel-heading"><span class="badge pull-right">2</span><?php echo Yii::t('app', "Méthode d'expédition"); ?></div>

	<table class="table table-striped">
		<thead>
			<tr><th><?php echo Yii::t('app', "Nom du service"); ?></th><th><?php echo Yii::t('app', "Jours de transit"); ?></th><th><?php echo Yii::t('app', "Prix"); ?></th><th></th></tr>
		</thead>
		<?php
	
		foreach ($methods as $method){
		
			if ($method->service_code === "DOM.EP" || $method->service_code === "INT.SP.AIR") {
				$checked = " checked";
			} else {
				$checked = "";
			}
			
			echo "<tr data-service='" . CHtml::encode($method->service_code) . "'>";
			if ($method->service_code === "pickup"){
				echo "<td>" . CHtml::encode($method->service_name) . " <span class='label label-warning'>" . Yii::t("app", "Nouveau!") . "</span></td>";
			} else {
				echo "<td>" . CHtml::encode($method->service_name) . "</td>";
			}
			echo "<td>" . CHtml::encode($method->service_standard_expected_transit_time) . "</td>";
			echo "<td>" . CHtml::encode($method->price_due) . "</td>";
			echo "<td><input type=\"radio\" name=\"shipment\" class=\"shipping_method\" data-cost='".CHtml::encode($method->price_due)."' value='" . CHtml::encode($method->service_code) . "'" . $checked . "></td>";
			echo "</tr>";
		
		}
	
		?>
	</table>

