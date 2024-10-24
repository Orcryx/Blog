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
        // $environnement = $_SERVER["REQUEST_URI"];
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
        $AdminController = new AdminController($commentManager, $this->twigService, $userManager);
        $contactController = new ContactController($this->twigService);
        $form = new ElementsController($this->twigService);
        $user = new UserModel($this->twigService);
        $isMethodPost = $_SERVER['REQUEST_METHOD'] === 'POST';
        // Récupérer l'ID de l'URL s'il est présent
        $queryString = explode('?', $uri)[1] ?? ''; // Obtenir la partie de la chaîne après le '?'
        $id = intval($queryString);
        $id = ($id === 0 && $queryString !== "0") ? null : $id;

        //Les autres route en fonction de l'action
        switch ($path) {
            case '/':
                $form->showIndex();
                break;
            case '/action':
                $form->showDynamicDialog();
                break;
            case '/contact':
                if ($isMethodPost) {
                    $contactController->sendEmail();
                } else {
                    $form->showFormContact();
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
            case '/admin':
                $AdminController->dashboardAdmin();
                break;
            case '/Comment/put':
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
                $userManager->logOut();
                break;
            default:
                $form->showPage404();
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
