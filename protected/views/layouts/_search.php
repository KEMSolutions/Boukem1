<!-- SEARCH -->
<div class="search-wr" id="divSearch">
	<span class="close" id="cmdCloseSearch" title="Fermez la recherche en cliquant sur ce bouton ou en appuyant sur la touche ESC"><i class="fa fa-times-circle"></i></span>
	<div class="container">
    	<div class="row">
        	<div class="col-md-1 col-xs-2 search-sign">
            	<i class="fa fa-search"></i>
            </div>
            <div class="col-md-11 col-xs-10">
				<form  method="get" action="<?php echo $this->createUrl('product/search'); ?>">
            	<input type="text" name="q" autofocus class="global-search-input" placeholder="<?php echo Yii::t("app", "Rechercher"); ?>" value="" autocomplete="off" spellcheck="false" dir="ltr">
			</form>
			</div>
            </div>
        </div>
    </div>
</div>