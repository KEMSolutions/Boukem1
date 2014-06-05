<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Boutique Démo',
	'theme'=>"kem",
	'sourceLanguage' => 'fr',
	
	'aliases' => array(
	    'bootstrap' => 'ext.bootstrap',
	),
	
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'bootstrap.behaviors.*',
		'bootstrap.helpers.*',
		'bootstrap.widgets.*'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'malahat',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array("*"),//'127.0.0.1', "70.83.71.167",'::1'),
			'generatorPaths' => array('bootstrap.gii'),
		),
		
		'api',
	),

	// application components
	'components'=>array(
		
		'session' => array (
		    //'timeout' => 172800,
		),
		
		'curl' => array(
			'class' => 'ext.curl.Curl',
			'options' => array(CURLOPT_FOLLOWLOCATION => false),
		),
		
		'user'=>array(
			'class'=>'WebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'elasticSearch' => array(
		        'class' => 'YiiElasticSearch\Connection',
		        'baseUrl' => 'http://localhost:9200/',
		),
		
		'urlManager'=>array(
			'class'     => 'ext.localeurls.LocaleUrlManager',
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				array('category/view', 'pattern'=>'cat/<slug:[a-zA-Z0-9-]+>', 'urlSuffix'=>'.html', 'caseSensitive'=>true),
				array('product/view', 'pattern'=>'prod/<slug:[a-zA-Z0-9-]+>', 'urlSuffix'=>'.html', 'caseSensitive'=>true),
				array('product/search', 'pattern'=>'search', 'caseSensitive'=>false),
				'/cart.html'=>'cart/index',
				'/panier.html'=>'cart/index',
				'/checkout.html'=>'cart/checkout',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		'bootstrap' => array(
			'class' => 'bootstrap.components.BsApi'
		),
		
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=boukem_demo',
			'emulatePrepare' => true,
			'username' => 'boukem_demo',
			'password' => 'kAq65A,12_39-3_=1_',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'request' => array(
		    'class'     => 'ext.localeurls.LocaleHttpRequest',
		    'languages' => array('en','fr'),

		    // Advanced configuration with defaults (see below)
		    'detectLanguage'           => true,
		    //'languageCookieLifetime'  => 31536000,
		    //'persistLanguage'         => true,
		    'redirectDefault'         => true,
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'elasticsearch_index' => "boutiquedemo_dev",
		'adminEmail'=>'support@kle-en-main.com',
		'inbound_api_user'=>'',
		'inbound_api_secret'=>'',
		'outbound_api_user'=>'',
		'outbound_api_secret'=>'',
	),
	
);