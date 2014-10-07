<?php
$language = Yii::app()->language;
?>
<section id="homepageCarousel" class="carousel carousel-1 slide <?php if (!isset($headline->background) && $headline->style === "dark"){
	echo "color-one";
} else {
	echo "color-two";
}
?>">
    <div class="carousel-inner">
    	<div class="item item-<?php echo $headline->style; ?> active"<?php
			if (isset($headline->background) && $headline->background !== "" && $headline->background !== ""){
				echo ' style="background-image:url(//cdn.kem.guru/layout/' . $headline->background . ')"';
			}
			 ?>>
            <div class="container">
                <div class="description fluid-center">
                	<span class="title"><?php echo $headline->title->$language; ?></span>
                    <span class="subtitle"><?php echo $headline->subtitle->$language; ?></span>
                    
                </div>
        	</div>
    	</div>
    </div>
</section>