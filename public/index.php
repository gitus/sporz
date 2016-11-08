<?php
require_once '../vendor/autoload.php';// Autoload our dependencies with Composer
require_once '../config/config.php';// config APP

use Pragma\View\View;
use Pragma\Router\Router;

// *** Enable view - uncomment following lines ***

// $view = View::getInstance();
// $view->set_tpl_path(APP_PATH . '/Views/');
// $view->setLayout('path-of-your-application-layout');

$app = Router::getInstance();

//define your routes here
$app->get('/', function(){//HOME PAGE
	//DO SOMETHING HERE
});

try{
	$app->run();
	// *** Enable view - uncomment the following line ***

	// $view->compute();
}
catch(Pragma\Router\RouterException $e){
	var_dump($e);
}
