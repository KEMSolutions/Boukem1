<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::t("app", 'Erreur') . " " . $code;
$this->layout = "//layouts/freestyle";

?>



<section class="slice color-one">
	<div class="w-section inverse">
    	<div class="container">
        	<div class="row">
                <div class="col-md-12">
                	<div class="text-center">
                    	<h2><?php echo Yii::t("app", "Oups...une erreur est survenue!"); ?></h2>
                    	<h1 class="font-lg">
                        	<?php if ($code == 404) {
								echo '4<i class="fa fa-times-circle-o"></i>4';
							} else {
								echo $code;
							} ?>
                        </h1>
                        
                        <p>
                           <?php echo CHtml::encode($message); ?>
                        </p>
                        <span class="clearfix"></span>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>