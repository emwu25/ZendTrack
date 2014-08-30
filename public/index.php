<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define hostname of supporting server
defined('SUPPORT_SERVER')
	|| define('SUPPORT_SERVER', "http://123turntable.com");

// Define hostname of this application 
defined('MY_HOSTNAME')
	|| define('MY_HOSTNAME', "http://123turntable.com");

// Define hash key 
defined('SALT')
	|| define('SALT', "123djhash");

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);




/** Routing Info **/
$FrontController = Zend_Controller_Front::getInstance();

//$plugin = new Zend_Controller_Plugin_ErrorHandler();
//$plugin->setErrorHandler(array("controller" => 'ApplicationError',
//"action" => 'index'));
//$FrontController->registerPlugin($plugin);


$Router = $FrontController->getRouter();




$Router->addRoute("artiststore",
	new Zend_Controller_Router_Route
	(
	"artist/store",
	array
	("controller" => "artist",
	 "action" => "artistaffiliatecontent"
	)
	));



$application->bootstrap()
            ->run();