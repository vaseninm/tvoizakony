<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Твои законы',
    'defaultController' => 'laws',
    'theme' => 'tz',
    'language' => 'ru',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'ext.yii-mail.YiiMailMessage',
		'ext.EUserFlash',
		'ext.helpers.*',
		'application.extensions.phaActiveColumn.*',
    ),
    'modules' => array(
    ),
    // application components
    'components' => array(
        'user' => array(
            'class' => 'WebUser',
            'allowAutoLogin' => true,
            'loginUrl' => array('/user/login'),
        ),
        // uncomment the following to enable URLs in path-format
        
        'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'lawdraft'=>array('laws/index', 'defaultParams'=>array('rating'=>0)),
				'lawdraft/<id:\d+>'=>'laws/view',
				'lawdraft/<action>'=>'laws/<action>',
				'profile/<username>'=>'user/profile',
				'page/<view>'=>'site/page',
			),
          ),
         

        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=tz',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'QWASZX',
            'charset' => 'utf8',
            'enableProfiling' => true,
			'schemaCachingDuration' => true,
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            //array(
            //'class'=>'CWebLogRoute',
            //),
            ),
        ),
		'cache'=>array(
            'class'=>'system.caching.CFileCache',
		),
        'authManager' => array(
            'class' => 'PhpAuthManager',
            'defaultRoles' => array('guest'),
        ),
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'php',
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false
        ),
		'twitter' => array(
                        'class' => 'ext.twitter.VGTwitter', // path to the twitter extension
                        'username' => 'tvoizakony', // login name, this is not required all the time but most api calls need this set
                        'password' => 'cjfctg', // password for the twitter account
                        'authenticate' => true, // if the twitter api call needs authentication then this must be set to true since by default it is set to false
                        'format' => 'json', // default is xml so we will configure this as rss for this example
        ),
		
		'breadCrumbs'=>array(
			'class'=>'ext.breadCrumbs.EBreadCrumbsComponent',
			// {@link CBreadcrumbs} widget options.
			'widget'=>array(
				'separator'=>' &rsaquo; ',
			),
		),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'no-reply@tvoizakony.ru',
    ),
);
