<?php

namespace App\service;

use App\controller\PostController;
use App\manager\PostManager;
use App\repository\PostRepository;

use App\controller\CommentController;
use App\manager\CommentManager;
use App\repository\CommentRepository;
use App\service\DatabaseService;
use App\service\UserService;
use App\repository\UserRepository;

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
        $isMethodPost = $_SERVER['REQUEST_METHOD'] === 'POST';
        if(isset($isMethodPost) && isset($_POST['email']))
                {
                    echo "je suis une requête POST";
                    var_dump($_POST['email']);
                    $dataBD = new DatabaseService();
                    $userRepo = new UserRepository($dataBD);
                    $userService = new UserService($userRepo);
                    $userService-> logIn();
                }
        //$isMethodGet = $_SERVER['REQUEST_METHOD'] === 'GET';

        // Récupérer l'ID de l'URL s'il est présent
        $queryString = explode('?', $uri)[1] ?? ''; // Obtenir la partie de la chaîne après le '?'
        $id = intval($queryString);
        $id = ($id === 0 && $queryString !== "0") ? null : $id;
    
        switch ($path) 
        {
            case '/':
                return $this->twigService->twigEnvironnement->render('index.twig');
            break;

            case '/blog':
                $dataBD = new DatabaseService();
                $postRepo = new PostRepository($dataBD);
                $postManager = new PostManager($postRepo);
                $commentRepo = new CommentRepository($dataBD);
                $commentManager = new CommentManager($commentRepo);  
                $blogController = new PostController($postManager, $commentManager );
            
                if ($id !==null) {
                    //echo "ID de la page .$id";
                    $blogController->displayOnePost($id); 
                    // if ($isMethodPost) {
                    //     $commentRepo = new PostRepository($dataBD);

                    //     $commentController->createComment();
                    // }
           
                }  else {
                   
                    $blogController->displayGallery();  
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