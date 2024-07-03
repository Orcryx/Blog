<?php

require "vendor/autoload.php";

use App\service\RouterService;
use Symfony\Component\Dotenv\Dotenv;

//Init Router
$router = new RouterService();

//Init variables d'env
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

//afficher le retour du routeur
echo $router->run($_SERVER['REQUEST_URI']);
