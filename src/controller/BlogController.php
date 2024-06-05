<?php
namespace App\controller;
use App\service\TwigService;
use App\manager\PostManager;


class BlogController
{


    private TwigService $twigService;

    //constructeur de la class 
    public function __construct()
    {
        $this->twigService = new TwigService();
    }

    public function displayGallery()
    {
        $posts = PostManager::getAll();
        return $this->twigService->twigEnvironnement->render('gallery.twig',['posts' => $posts]);

    }


}