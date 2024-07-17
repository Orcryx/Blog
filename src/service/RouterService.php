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
use App\controller\ElementsController;

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
        //$environnement = $_SERVER["REQUEST_URI"];
        $dataBD = new DatabaseService();
        $userRepo = new UserRepository($dataBD);
        $userService = new UserService($userRepo);
       
        $isMethodPost = $_SERVER['REQUEST_METHOD'] === 'POST';
        if(isset($isMethodPost) && isset($_POST['email']) && isset($_POST['password']))
        {
            $userService-> logIn();
        }

        // Récupérer l'ID de l'URL s'il est présent
        $queryString = explode('?', $uri)[1] ?? ''; // Obtenir la partie de la chaîne après le '?'
        $id = intval($queryString);
        $id = ($id === 0 && $queryString !== "0") ? null : $id;
    
        switch ($path) 
        {
            case '/':
                return $this->twigService->render('index.twig');
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
                }  else {
                   
                    $blogController->displayGallery();  
                }   
            break;
             case '/auth':
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        $_SESSION['previous_url'] = $_SERVER['HTTP_REFERER'];
                       // echo "si création de previous_url" .$_SESSION['previous_url'];
                    } else {
                        $_SESSION['previous_url'] = '/blog'; // Page par défaut si HTTP_REFERER n'est pas défini
                       // echo "si il n'y a pas de previous_url" . $_SESSION['previous_url'];
                    }
                    $form = new ElementsController;
                    $form->showLoginDialogue($_SESSION['previous_url']);
                break;
            case '/contact':
                return $this->twigService->render('contact_include.twig');
            break;
            case '/admin':
                return $this->twigService->render('contact_include.twig');
            break;
            case '/test':
                return $this->twigService->render('test.twig');
            break;
            default:
                http_response_code(404);
                echo $this->twigService->render('404.twig'); 
            break;
        }

    }


}