<?php
namespace App\controller;
use App\service\TwigService;
use App\manager\PostManager;


class PostController
{


    private TwigService $twigService;
    private PostManager $postManager;

    //constructeur de la class 
    public function __construct(PostManager $postManager)
    {
        $this->twigService = new TwigService();
        $this->postManager = $postManager;
    }

    public function displayGallery()
    {
        echo "je suis un oiseau";
        echo "je suis un pan";
        $posts = $this->postManager->getAll();
        var_dump($posts);
        echo "je suis une fourmis ";
        return $this->twigService->twigEnvironnement->render('gallery.twig',['posts' => $posts]);

    }


}