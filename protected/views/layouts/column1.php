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