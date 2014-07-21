<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<!-- PAGE INFO -->
<div class="pg-opt pin">
	<div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2><?php echo $this->pageTitle; ?></h2>
            </div>
            <?php /* <div class="col-md-6">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Pages</a></li>
                    <li class="active">Breadcrumb</li>
                </ol>
            </div>
            */ ?>
        </div>
    </div>
</div>

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