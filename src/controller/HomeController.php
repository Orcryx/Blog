<?php
namespace App\controller;
use App\service\TwigService;

class HomeController
{

    private TwigService $twigService;

    //constructeur de la class 
    public function __construct()
    {
        $this->twigService = new TwigService();
    }

    public function displayHome()
    {
        return $this->twigService->twigEnvironnement->render('index.twig');
    }
}