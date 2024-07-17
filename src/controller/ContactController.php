<?php
namespace App\controller;
use App\service\TwigService;

class ContactController
{

    //constructeur de la class 
    public function __construct(private readonly TwigService $twigService)
    {
     
    }
    
    public function getForm()
    {
    
        return $this->twigService->render('contact_include.twig');
    }
}