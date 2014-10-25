<?php
$tabVariableName = "title_" . Yii::app()->language . "_CA";
if (isset($layout->tab) && isset($layout->tab->$tabVariableName)) {
	echo '<div class="section-title color-three"><h3>' . $layout->tab->$tabVariableName . '</h3><div class="indicator-down color-three"></div></div>';
}
?>