<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="container main-container">
	<div class="row">
		
		<div class="col-md-3">
			<?php
				$this->beginWidget('zii.widgets.CPortlet', array(
					'title'=>$this->menuTitle,
					'titleCssClass'=>"title",
					'decorationCssClass'=>'no-padding',
				));
				$this->widget('zii.widgets.CMenu', array(
					'items'=>$this->menu,
					'htmlOptions'=>array('class'=>'list-group'),
					'itemCssClass'=>"list-group-item",
				));
				$this->endWidget();
			?>
		</div>
		
		<div class="col-md-9">
				<?php echo $content; ?>
		</div>
	</div>
</div>
<?php $this->endContent(); ?>