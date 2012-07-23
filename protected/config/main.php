<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => '比邻网络',
    // preloading 'log' component
    'preload' => array('log', 'bootstrap'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.models.forms.*',
        'application.components.*',
        'application.application.*',
        'application.application.ui.*',
        'application.application.db.*',
        'application.application.auth.*',
        'application.application.app.*',
        'application.application.meta.*',
        'application.application.ui.form.*',
        'application.application.ui.view.*',
        'application.application.ui.view.assets.*',
        'application.application.ui.screen.*',
        'application.application.ui.screenflow.*',
        'application.application.ui.screenflow.*',
        'application.application.ui.form.meta.*',
        'application.application.ui.form.model.*',
        'application.application.ui.form.view.*'
    ),
    'sourceLanguage' => 'en_us',
    'language' => 'zh_cn',
    'modules' => array(
        // uncomment the following to enable the Gii tool
        ///*
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'bilyn',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array('bootstrap.gii')
        ),
    //*/
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication          
            'allowAutoLogin' => true,
            'loginUrl' => array('site/loginTab'),
        ),
        'bootstrap' => array('class' => 'ext.bootstrap.components.Bootstrap',),
        // uncomment the following to enable URLs in path-format

        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                //       '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                //       '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                //    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                //    's/<serviceId>/d/<operationId>'=>'service/do',                
                //'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                //'go/<bn:\d+>' => 'site/index'
                
            ),
        ),
        /*
          'db'=>array(
          'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
          ),
         */
        // uncomment the following to use a MySQL database
        ///*
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=bilyn',
            'emulatePrepare' => true,
            'username' => 'blndba',
            'password' => 'blnpwd',
            'charset' => 'utf8',
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
        ),
        //*/
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
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
        /*
          'db' => array(
          'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../data/testdrive.db',
          ),
         */

        // uncomment the following to use a MySQL database
        /*
          'db'=>array(
          'connectionString' => 'mysql:host=localhost;dbname=testdrive',
          'emulatePrepare' => true,
          'username' => 'root',
          'password' => '',
          'charset' => 'utf8',
          ),
         */
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
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@bilyn.com',
    ),
);
