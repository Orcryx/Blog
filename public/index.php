<?php

use router\router;
require "../vendor/autoload.php";


// echo "page index";

$router = new Router();

$router->get('/public/index', ['controller\home','getHome']); 
// $router->get('/public/contact.php', ['controller\home' , 'getHome']); 

// echo '<pre>';
// var_dump($router);
// echo '</pre>';

// echo '<br>';
// var_dump(explode('?', $_SERVER['REQUEST_URI']));
// echo '<br>';

//afficher le retour du routeur
echo $router->run($_SERVER['REQUEST_URI']);
