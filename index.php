<?php

require "vendor/autoload.php";

use App\service\RouterService;

//Init Router
$router = new RouterService();

//afficher le retour du routeur
echo $router->run($_SERVER['REQUEST_URI']);
