<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'ikway',
            
            'language'=>'ru',
            'sourceLanguage'=>'en_us',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
   /* YII-USER */             'application.modules.user.models.*',
    /* YII-USER */            'application.modules.user.components.*',
            
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
            

	/* YII-USER */	'user',
            ),

	// application components
	'components'=>array(
           
            'user'=>array(
		'class'=>'WebUser',
                'loginUrl' => array('/user/login'),
                'autoRenewCookie'=>true,
                'allowAutoLogin'=>true,
                         ),
            
            'phpThumb'=>array(
                'class'=>'ext.EPhpThumb.EPhpThumb.EPhpThumb',
                             ),
	
            'session'=>array(
		'class'=>'DbSession',
                'connectionID'=>'db',
                'sessionTableName'=>'Sessions',
                'autoStart'=>'false',
                'sessionName'=>'ikway_sid'
                ),
            
                // uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=ikway',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
/* YII-USER */            'tablePrefix'=>'tbl_',
                    
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CWebLogRoute',
				'categories'=>'application',
                                    'levels'=>'error, warning,trace, profile, info',
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
		'adminEmail'=>'webmaster@example.com',

	),
);