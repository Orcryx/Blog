<?php

use router\router;
require "../vendor/autoload.php";

$router = new Router();

$router->get('/public/index', ['controller\home','getHome']); 
$router->get('/public/blog', ['controller\blog' , 'getGallery']);
$router->get('/public/contact', ['controller\contact' , 'getForm']); 

// $router->getOne('/public/blog', ['controller\blog', 'getPost'], $id);

//afficher le retour du routeur
echo $router->run($_SERVER['REQUEST_URI']);
