<?php

require "vendor/autoload.php";
use App\service\RouterService;

//Init Router
$router = new RouterService();

$router->get('/', ['App\controller\HomeController','displayHome']); 
$router->get('/blog', ['App\controller\BlogController' , 'displayGallery']);
$router->get('/contact', ['App\controller\ContactController' , 'getForm']); 
// $router->getOne('/public/post', ['controller\blog', 'displayPost'], [$id]);

//afficher le retour du routeur
echo $router->run($_SERVER['REQUEST_URI']);
