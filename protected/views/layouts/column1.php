<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<!-- PAGE INFO -->
<div class="pg-opt pin">
	<div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2><?php echo $this->pageTitle; ?></h2>
            </div>
	            <?php 
				if ($this->breadcrumbs):
				?>
				<div class="col-md-6">
                
						<?php $this->widget('zii.widgets.CBreadcrumbs', array(
						    'links'=>$this->breadcrumbs,
							'separator'=>"",
							'tagName'=>'ol',
							'homeLink'=>false,
							'htmlOptions'=>array('class'=>"breadcrumb"),
							'activeLinkTemplate'=>'<li><a href="{url}">{label}</a></li>',
							'inactiveLinkTemplate'=>'<li class="active">{label}</li>',
						));
						?>
                    
	            </div>
			<?php 
			endif;
	             ?>
        </div>
    </div>
</div>


<section class="slice color-three">
	<div class="w-section inverse">
    	<div class="container">
			<div class="row">
			<div class="col-xs-12">
			<?php echo $content; ?>
		</div>
	</div>
</div><!-- content -->
</div>
</section>
<?php $this->endContent(); ?>