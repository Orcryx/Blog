<?php

namespace App\service;

use App\controller\CommentController;
use App\controller\PostController;
use App\manager\PostManager;
use App\repository\PostRepository;

// use App\controller\CommentController;
use App\manager\CommentManager;
use App\repository\CommentRepository;
use App\service\DatabaseService;
use App\service\UserService;
use App\repository\UserRepository;
use App\controller\ElementsController;
use App\controller\AdminController;

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
        if ($isMethodPost)
        {
            $formType = $_POST['formType'] ?? '';
            if ($formType === 'login' && isset($_POST['email']) && isset($_POST['password'])) {
                // Action de connexion
                $userService->logIn();
            } 
            elseif ($formType === 'register' && isset($_POST['name']) && isset($_POST['firstName']) && isset($_POST['nickname']) && isset($_POST['email']) && isset($_POST['password'])) 
            {
                // Action d'enregistrement
                $userService->register();
            } 
            else 
            {
                // Gérer les erreurs ou les cas où les champs nécessaires ne sont pas présents
                // Par exemple, vous pourriez rediriger l'utilisateur vers une page d'erreur ou afficher un message d'erreur
            }
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
                $blogController = new PostController($postManager, $commentManager, $this->twigService, $userService );
            
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
                    $_SESSION['previous_url'] = '/auth'; // Page par défaut si HTTP_REFERER n'est pas défini
                    // echo "si il n'y a pas de previous_url" . $_SESSION['previous_url'];
                }
                $form = new ElementsController($this->twigService );
                $form->showLoginDialogue($_SESSION['previous_url']);
            break;
            case '/addComment':
                if ($isMethodPost) {
                    $dataBD = new DatabaseService();
                    $commentRepo = new CommentRepository($dataBD);
                    $commentManager = new CommentManager($commentRepo);
                    $commentController = new CommentController($commentManager, $this->twigService);
                    if (isset($_POST['comment']) && isset($_POST['postId']) && isset($_POST['userId'])) {
                        $commentText = $_POST['comment'];
                        $postId = intval($_POST['postId']);
                        $userId = intval($_POST['userId']);
                        $isValidated = 0; // selon votre logique de validation par modération
            
                        // Appeler la méthode pour ajouter le commentaire
                        $result = $commentController->addComment($postId, $commentText, $userId, $isValidated);
                        
                        echo $result;
                    } else {
                        //Afficher un message d'erreur
                        echo "Erreur: tous les champs ne sont pas remplis.";
                    }
                } else {
                    // Gérer l'accès via GET ou d'autres méthodes HTTP
                    echo "Erreur: méthode non autorisée.";
                }
                break;
                case '/deleteComment':
                    if ($isMethodPost) {
                        $dataBD = new DatabaseService();
                        $commentRepo = new CommentRepository($dataBD);
                        $commentManager = new CommentManager($commentRepo);
                        $commentController = new CommentController($commentManager, $this->twigService);
                        if (isset($_POST['commentId'])){
                            $commentId = $_POST['commentId'];
                            // Appeler la méthode pour ajouter le commentaire
                            $result = $commentController->deleteComment($commentId);
                            
                           // echo $result;
                        }
                    }
                    break;
            case '/contact':
                return $this->twigService->render('contact_include.twig');
            break;
            case '/admin':
                 // Instancier les services nécessaires
                $dataBD = new DatabaseService();
                $commentRepo = new CommentRepository($dataBD);
                $commentManager = new CommentManager($commentRepo);
                $AdminController = new AdminController($commentManager, $this->twigService, $userService);
               
                
                $AdminController->dashboardAdmin();
              
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