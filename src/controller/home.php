<?php
namespace App\controller;
use App\service\TwigService;

class home
{

    private TwigService $twigService;

    //constructeur de la class 
    public function __construct()
    {
        $this->twigService = new TwigService();
    }

    public function getHome()
    {
        return $this->twigService->twigEnvironnement->render('index.twig');
    }
}