<?php
namespace App\controller;
use App\service\TwigService;

class ContactController
{

    private TwigService $twigService;

    //constructeur de la class 
    public function __construct()
    {
        $this->twigService = new TwigService();
    }
    
    public function getForm()
    {
    
        return $this->twigService->render('contact_include.twig');
    }
}