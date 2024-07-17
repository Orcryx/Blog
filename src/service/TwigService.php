<?php

declare(strict_types=1);

namespace App\service;
use Twig\Loader\FilesystemLoader;
use Twig\Environment; 
use Twig\Extension\DebugExtension;


class TwigService {

    //readonly ne peut set la variable qu"une seule fois
    public readonly Environment $twigEnvironnement;


    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../view');
        $twig = new Environment($loader, ['debug' => true,]); 
        $twig->addExtension(new DebugExtension());

         // Ajouter la session comme variable globale
         if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $twig->addGlobal('session', $_SESSION);

        $this->twigEnvironnement = $twig;
    }

    public function render(string $template, array $context = [])
    {
        // Vous pouvez également ajouter des contextes par défaut ici si nécessaire
        echo $this->twigEnvironnement->render($template, $context);
    }
}