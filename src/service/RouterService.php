<?php

namespace App\service;

use App\controller\CommentController;
use App\controller\PostController;
use App\controller\ContactController;
use App\controller\ElementsController;
use App\controller\AdminController;
use App\controller\UserModel;
use App\repository\CommentRepository;
use App\repository\PostRepository;
use App\repository\UserRepository;
use App\manager\CommentManager;
use App\manager\UserManager;
use App\manager\PostManager;
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
        //$environnement = $_SERVER["REQUEST_URI"];
        //Préparer les class du projet
        $dataBD = new DatabaseService();
        $userRepo = new UserRepository($dataBD);
        $userManager = new UserManager($userRepo);
        $postRepo = new PostRepository($dataBD);
        $postManager = new PostManager($postRepo);
        $commentRepo = new CommentRepository($dataBD);
        $commentManager = new CommentManager($commentRepo);
        $blogController = new PostController($postManager, $commentManager, $this->twigService, $userManager);
        $commentController = new CommentController($commentManager, $this->twigService);
        $postController = new PostController($postManager, $commentManager, $this->twigService, $userManager);
        $form = new ElementsController($this->twigService);
        $user = new UserModel($this->twigService);
        $isMethodPost = $_SERVER['REQUEST_METHOD'] === 'POST';
        //$isMethodGet = $_SERVER['REQUEST_METHOD'] === 'GET';
        // Récupérer l'ID de l'URL s'il est présent
        $queryString = explode('?', $uri)[1] ?? ''; // Obtenir la partie de la chaîne après le '?'
        $id = intval($queryString);
        $id = ($id === 0 && $queryString !== "0") ? null : $id;

        //Les autres route en fonction de l'action
        switch ($path) {
            case '/':
                echo $this->twigService->render('index.twig');
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
                $url = $this->backUrl();
                if ($isMethodPost) {
                    $user->showAuth();
                }
                $form->showLoginDialogue($url);
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
                $AdminController = new AdminController($commentManager, $this->twigService, $userManager);
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
                $userManager->logOut();
                break;
            default:
                http_response_code(404);
                echo $this->twigService->render('404.twig');
                break;
        }
    }

    public function backUrl()
    {
        // Stocker l'URL actuelle dans une variable PHP
        $current_url = $_SERVER['HTTP_REFERER'];
        // Si le formulaire est soumis, stockez l'URL dans la session
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['last_url'] = $_POST['current_url'];
            $current_url = $_SESSION['last_url'];
        }
        return $current_url;
    }
}
