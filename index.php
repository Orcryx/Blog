<?php

require "vendor/autoload.php";

use App\service\RouterService;
use Symfony\Component\Dotenv\Dotenv;

//Init variables d'env
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env', __DIR__ . '/.env.dev');

//session start
session_set_cookie_params(600);
session_start();

//Init Router
$router = new RouterService();
//afficher le retour du routeur
echo $router->run($_SERVER['REQUEST_URI']);
