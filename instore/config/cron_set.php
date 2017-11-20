<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
		'name'=>'Cron',

		// preloading 'log' component
		'preload'=>array('log'),

		// autoloading model and component classes
		'import'=>array(
				'application.models.*',
				'application.components.*',
		),
		// application components
		'components'=>array(
				// uncomment the following to use a MySQL database

				'db'=>array(
						'connectionString' => 'mysql:host=localhost;dbname=indore',
						'emulatePrepare' => true,
						'username' => 'root',
						'password' => '',
						'charset' => 'utf8',
						'tablePrefix' => 'tbl_',
				),
				'log'=>array(
						'class'=>'CLogRouter',
						'routes'=>array(
								array(
										'class'=>'CFileLogRoute',
										'levels'=>'error, warning',
								),
								 array(
									'class'=>'CFileLogRoute',
									'logFile'=>'cron_trace.log',
									'levels'=>'trace',
								),
								// uncomment the following to show log messages on web pages

								array(
										'class'=>'CWebLogRoute',
								),

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