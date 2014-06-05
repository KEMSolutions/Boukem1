<?php

class CategoryController extends WebController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * Displays a particular model.
	 * @param str $slug the 'slug' identifier of the model to be displayed
	 */
	public function actionView($slug)
	{
        //var_dump($slug);
        //exit;
		// Retrieve the model via it's slug
		$model_localization = $this->loadLocalizationModelSlug($slug);
		
		$model = $model_localization->category;

		$this->pageTitle = $model_localization->name . " - " . Yii::app()->name;
		
		
		// Generate the subcategories to display in the sidebar.
		# TODO Cache this before launch
		$this->menu=array();
		foreach ($model->children as $children){
			
			$localization = $children->localizationForLanguage(Yii::app()->language, $accept_substitute=false);
			
			if ($localization !== null)
				$this->menu[] = array('label'=>$localization->name, 'url'=>array('category/view', "slug"=>$localization->slug));
		}
		
		
		if ($model->parent_category){
			// This is a subcategory
			// Subcategories must display their products. They must also add their parents categories to the page's breadcrumbs
			
			// Display breadcrumbs in the right order (home >> root category >> subcategory 1 >> subcatory 2, etc.)
			$this->breadcrumbs = array();
			function appendMotherCatToBreadcrumbs($cat, &$breadarray, $locale){

                $locale_category = CategoryLocalization::model()->find("category_id = :category AND locale_id = :locale", array(":category"=>$cat->id, ":locale"=>$locale));


				$breadarray[$locale_category->name] = array("category/view", "slug"=>$locale_category->slug);
				if ($cat->parent_category){
					appendMotherCatToBreadcrumbs($cat->parentCategory, $breadarray, $locale);
				}

			}


			if ($model->parent_category){
				appendMotherCatToBreadcrumbs($model->parentCategory, $this->breadcrumbs, Yii::app()->language);
				// The array returned is reversed (top category at the end) we need to reverse it.
				$this->breadcrumbs = array_reverse($this->breadcrumbs);
			}
			// We're at the end of the run, just append our name
			$this->breadcrumbs[] = $model_localization->name;
			
			
			// Retrieve the order's products (with the correct localization)
			$current_locale = Yii::app()->language;

			$products_data_provider = null;



			//////////////////////////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////////////////
			/* Hi Ivan,
			Here's the part of the code I'll need your help with.
			I must retrieve, building a CActiveDataProvider, the list of all Products available (or the ProductLocalizations themselves) for the category. Not all products, however, have a ProductLocalization for the current language (available by calling Yii::app()->language). Therefore I must filter the Products by category AND localization. And that I have no idea how to do.
			If you need to edit the database itself, just tell me so I can create you an access to PHPMyAdmin.
			
			Thanks!
			Remy
			*/
			//////////////////////////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////////////////


            $product = new Product();
            $product->unsetAttributes();
            $product->categoryId = $model->id;

			$this->render('view',array(
				'model'         => $model,
				'localization'  => $model_localization,
				'products'      => $product->search(),
			));
			
		} else {
			// We're dealing with a top category
			// Top categories will NOT display products but some static html invite to choose a subcategory
			$this->render('rootcat',array(
				'model'=>$model,
				'localization'=>$model_localization,
			));
		}
		
		
	}

	

	


	/**
	 * Returns the data model based on the primary key (id) given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Category the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('app', 'La page demandée n\'existe pas.'));
		return $model;
	}
	
	/**
	 * Returns the localization model based on the localization's slug key given in the GET variable.
	 * If the data model is not found, an HTTP exception of type 404 will be raised.
	 * @param str $slug the slug key of the model to be loaded
	 * @return CategoryLocalization the loaded model
	 * @throws CHttpException
	 */
	public function loadLocalizationModelSlug($slug)
	{
	    $model = CategoryLocalization::model()->findByAttributes(array('slug'=>$slug));
		
		// Check if model exists
	    if($model===null)
	        throw new CHttpException(404,Yii::t('app', 'La page demandée n\'existe pas.'));
		
		// If model exists, make sure it's in the same language as the site global variable
		if ($model->locale_id !== Yii::app()->language) {
			// Current slug doesn't exist in the appropriate language. Redirect the user to the appropriate language (if any)
			
			$appropriate_model = $model->category->localizationForLanguage(Yii::app()->language, $accept_substitute=false);
			
			if ($appropriate_model){
				// Redirect to that localized model
				$redict_url = $this->createUrl(Yii::app()->controller->action->id, array('slug'=>$appropriate_model->slug, 'language'=>$appropriate_model->locale_id));
				$this->redirect($redict_url);
			}
			// This product doesn't have a localization in the current's site language
			throw new CHttpException(404,Yii::t('app', 'La page demandée n\'existe pas.'));
		}
		
	    
	    return $model;
	}
	
	
}
