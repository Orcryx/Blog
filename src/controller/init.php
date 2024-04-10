<?php

// check la compatibilité des variables passées dans les objets
declare(strict_types=1);

require 'vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment; 
use Twig\Extension\DebugExtension;

$loader = new FilesystemLoader('src/view');
$twig = new Environment($loader, ['debug' => true,]); 
$twig->addExtension(new DebugExtension());