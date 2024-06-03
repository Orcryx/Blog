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
        $this->twigEnvironnement=$twig;
    }

    //il faut typer la sortie
    // public function getTwigEnvironnement():Environment{
    //     return $this->twigEnvironnement;
    // }

    // public function init(){
    //     $twig = new TwigService();
    //     $twig->twigEnvironnement->render('viex');
    // }



}