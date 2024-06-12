<?php

namespace App\service;

use App\controller\PostController;
use App\manager\PostManager;
use App\repository\PostRepository;
use App\service\DatabaseService;


class RouterService
{
    private TwigService $twigService;

    //constructeur de la class routeur
    public function __construct()
    {
        $this->twigService = new TwigService();
    }

    public function run(string $uri)
    {
        $path = explode('?', $uri)[0];

        // Récupérer l'ID de l'URL s'il est présent
        $queryString = explode('?', $uri)[1] ?? ''; // Obtenir la partie de la chaîne après le '?'
        $id = intval($queryString);
        $id = ($id === 0 && $queryString !== "0") ? null : $id;
       
        //vérifier si le tableau avec le namespace/**  existe
    
        switch ($path) 
        {
            case '/':
                return $this->twigService->twigEnvironnement->render('index.twig');
            break;

            case '/blog':
                $dataBD = new DatabaseService();
                var_dump("1");
                $postRepo = new PostRepository($dataBD);
                var_dump("2");
                $postManager = new PostManager($postRepo ); 
                var_dump("3");
                $blogController = new PostController($postManager);
                var_dump("4");
                $blogController->displayGallery();   
                if ($id !==null) {
                    # code...
                    echo "il y a un ID . $id";
                }  else {
                    http_response_code(404);
                    echo $this->twigService->twigEnvironnement->render('404.twig'); 
                }   
            break;
            case '/contact':
                return $this->twigService->twigEnvironnement->render('contact_include.twig');
            break;
            case '/admin':
                return $this->twigService->twigEnvironnement->render('contact_include.twig');
            break;
            default:
                http_response_code(404);
                echo $this->twigService->twigEnvironnement->render('404.twig'); 
            break;
        }

    }


}