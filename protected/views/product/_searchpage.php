<div class="w-section inverse blog-grid">
	<div class="container">
    	<div id="masonryWr" class="row">
			
			<?php
			
				 foreach ($results->items as $item){
	
						$product = Product::model()->findByPk($item);
						if (!$product){
							continue;
						}
						
						$localization = $product->localizationForLanguage(Yii::app()->language, $accept_substitute=false);
						if (!$localization){
							continue;
						}
						
						if ($product && $localization && $product->visible && !$product->discontinued){
							$this->renderPartial("application.views._product_card", array("product"=>$product, "style"=>"fs", "localization"=>$localization));
						}
					
					}
				?>

		</div>
	</div>
</div>
<div>
	<ul class="pagination">
		<?php
		
		$counter = 1;
		while ($counter <= $results->pagination->pageCount){
			echo '<li' . (($results->pagination->currentPage+1 == $counter) ? ' class="active"' : "") . '><a href="' . $this->createUrl("search", array("page"=>$counter-1, "q"=>CHtml::encode($q))) . '">' . $counter . '</a></li>';
			$counter++;
		}
		
		?>
	  
	</ul>
</div>