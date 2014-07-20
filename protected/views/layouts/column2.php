<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<section class="slice animate-hover-slide">
	<div class="w-section inverse blog-grid">
		<div class="container">
			<div class="row">
		<div class="col-md-4">
			<?php
				$this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>"<h4 class='widget-heading'>" . $this->menuTitle . "</h4>",
					'htmlOptions'=>array("class"=>"widget"),
				));
				$this->widget('zii.widgets.CMenu', array(
					'items'=>$this->menu,
					'htmlOptions'=>array('class'=>'categories highlight'),
				));
				$this->endWidget();
			?>
		</div>
		
		
	            <div class="col-md-8">
				<?php echo $content; ?>
				
				</div>
			</div>
	</div>
</section>
<?php $this->endContent(); ?>