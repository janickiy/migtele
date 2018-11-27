<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Mainlanding',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.render.*',
		'application.components.savers.*',
		'application.components.clickCounter.*',
		'application.components.redirect.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		//'admin',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'gii',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),	
        // 'admin',	
	),
	
	// application components
	'components'=>array(		
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'caseSensitive'=>false, 
			'rules'=>array(
				//'<lang:(en|ru)>/<controller:\w+>/<id:\d+>'=>'<controller>/view?lang=<lang>',						
				'<controller:\w+>'=>'<controller>',				
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),		
		// uncomment the following to use a MySQL database		
		'db' => require(dirname(__FILE__) . '/db.php'),	
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CWebLogRoute',
                    'levels'=>'trace, info, error, warning',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    // 'categories' => 'system.db.*',
                    'levels'=>'trace, info, error, warning',
                ),

            ),
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'makcumka2000@gmail.com',
	),
	'sourceLanguage' => 'ru',
);