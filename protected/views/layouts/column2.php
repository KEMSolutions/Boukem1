<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<div class="row">
		
		<div class="col-md-4">
			<?php
				$this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>'Operations',
				));
				$this->widget('zii.widgets.CMenu', array(
					'items'=>$this->menu,
					'htmlOptions'=>array('class'=>'list-group'),
					'itemCssClass'=>"list-group-item",
				));
				$this->endWidget();
			?>
		</div>
		
		<div class="col-md-8">
				<?php echo $content; ?>
		</div>
	</div>
</div>
<?php $this->endContent(); ?>