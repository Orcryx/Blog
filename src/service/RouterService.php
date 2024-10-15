<?php

namespace App\service;

use App\controller\CommentController;
use App\controller\PostController;
use App\controller\ContactController;
use App\manager\PostManager;
use App\repository\PostRepository;
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
        //Préparer les class du projet
        $dataBD = new DatabaseService();
        $userRepo = new UserRepository($dataBD);
        $userService = new UserService($userRepo);
        $postRepo = new PostRepository($dataBD);
        $postManager = new PostManager($postRepo);
        $commentRepo = new CommentRepository($dataBD);
        $commentManager = new CommentManager($commentRepo);
        $blogController = new PostController($postManager, $commentManager, $this->twigService, $userService);
        $commentController = new CommentController($commentManager, $this->twigService);
        $postController = new PostController($postManager, $commentManager, $this->twigService, $userService);
        $form = new ElementsController($this->twigService);
        $isMethodPost = $_SERVER['REQUEST_METHOD'] === 'POST';
        //$isMethodGet = $_SERVER['REQUEST_METHOD'] === 'GET';
        // Récupérer l'ID de l'URL s'il est présent
        $queryString = explode('?', $uri)[1] ?? ''; // Obtenir la partie de la chaîne après le '?'
        $id = intval($queryString);
        $id = ($id === 0 && $queryString !== "0") ? null : $id;
        //Spécifique à l'authentification
        if ($isMethodPost) {
            $formType = $_POST['formType'] ?? '';
            if ($formType === 'login' && isset($_POST['email']) && isset($_POST['password'])) {
                // Action de connexion
                $userService->logIn();
            } elseif (
                $formType === 'register' && isset($_POST['name']) && isset($_POST['firstName'])
                && isset($_POST['nickname']) && isset($_POST['email']) && isset($_POST['password'])
            ) {
                // Action d'enregistrement
                $userService->register();
            } else {
                //Gérer les erreurs ici
            }
        }
        //Les autres route en fonction de l'action
        switch ($path) {
            case '/':
                return $this->twigService->render('index.twig');
                break;
            case '/action':
                $form->showDynamicDialog();
                break;
            case '/contact':
                $contactController = new ContactController($this->twigService);
                if ($isMethodPost) {
                    // Récupérer les données du formulaire
                    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
                    $message = htmlspecialchars(trim($_POST['message'] ?? ''));
                    // Appeler la méthode sendEmail
                    $contactController->sendEmail($email, $message);
                } else {
                    // Afficher le formulaire de contact
                    return $contactController->getForm();
                }
                break;
            case '/blog':
                if ($id !== null) {
                    //echo "ID de la page .$id";
                    $blogController->displayOnePost($id);
                } else {
                    $blogController->displayGallery();
                }
                break;
            case '/auth':
                if (isset($_SERVER['HTTP_REFERER'])) {
                    $_SESSION['previous_url'] = $_SERVER['HTTP_REFERER'];
                } else {
                    // Page par défaut si HTTP_REFERER n'est pas défini
                    $_SESSION['previous_url'] = '/auth';
                }
                $form->showLoginDialogue($_SESSION['previous_url']);
                break;
            case '/comment/add':
                if ($isMethodPost) {
                    $commentController->addComment();
                } else {
                    echo "Erreur: méthode non autorisée.";
                }
                break;
            case '/Comment/delete':
                if ($isMethodPost) {
                    $commentController->deleteComment();
                }
                break;
            case '/Comment/update':
                if ($isMethodPost) {
                    $commentController->updateComment();
                }
                break;
            case '/contact':
                return $this->twigService->render('contact_include.twig');
                if ($isMethodPost) {
                    // Récupérer les données du formulaire
                    $email = htmlspecialchars(trim($_POST['user-mail']));
                    $message = htmlspecialchars(trim($_POST['user-msg']));
                    return $this->twigService->render();
                }
                break;
            case '/admin':
                $AdminController = new AdminController($commentManager, $this->twigService, $userService);
                $AdminController->dashboardAdmin();
                break;
            case '/Comment/put':
                $commentController = new CommentController($commentManager, $this->twigService);
                $commentController->publishComment();
                break;
            case '/Post/post':
                if ($isMethodPost) {
                    $postController->createOnePost();
                }
                break;
            case '/Post/delete':
                if ($isMethodPost) {
                    $postController->deleteOnePost();
                }
                break;
            case '/Post/put':
                if ($isMethodPost) {
                    $postController->updateOnePost();
                }
                break;
            case '/logOut':
                $_SESSION['previous_url'] = $_SERVER['HTTP_REFERER'] ?? '/';
                $userService->logOut();
                break;
            default:
                http_response_code(404);
                echo $this->twigService->render('404.twig');
                break;
        }
    }
}
