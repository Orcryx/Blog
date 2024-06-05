<?php

require "../vendor/autoload.php";
use App\service\Router;

$router = new Router();

$router->get('/public/index', ['App\controller\home','getHome']); 
$router->get('/public/blog', ['App\controller\blog' , 'getGallery']);
$router->get('/public/contact', ['App\controller\contact' , 'getForm']); 

// $router->getOne('/public/blog', ['controller\blog', 'getPost'], $id);

//afficher le retour du routeur
echo $router->run($_SERVER['REQUEST_URI']);
