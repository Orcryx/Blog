<?php

namespace App\service;

use App\controller\CommentController;
use App\controller\PostController;
use App\controller\ContactController;
use App\controller\ElementsController;
use App\controller\AdminController;
use App\controller\UserController;
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
    private ?UserController $userController = null;
    private ?CommentController $commentController = null;
    private ?PostController $postController = null;
    private ?AdminController $adminController = null;
    private ?ContactController $contactController = null;
    private ?ElementsController $elementsController = null;
    private ?UserManager $userManager = null;
    private ?CommentManager $commentManager = null;
    private ?PostManager $postManager = null;

    public function __construct()
    {
        $this->twigService = new TwigService();
    }

    private function getUserManager(): UserManager
    {
        if ($this->userManager === null) {
            $dataBD = new DatabaseService();
            $userRepo = new UserRepository($dataBD);
            $this->userManager = new UserManager($userRepo);
        }
        return $this->userManager;
    }

    private function getCommentManager(): CommentManager
    {
        if ($this->commentManager === null) {
            $dataBD = new DatabaseService();
            $commentRepo = new CommentRepository($dataBD);
            $this->commentManager = new CommentManager($commentRepo);
        }
        return $this->commentManager;
    }

    private function getPostManager(): PostManager
    {
        if ($this->postManager === null) {
            $dataBD = new DatabaseService();
            $postRepo = new PostRepository($dataBD);
            $this->postManager = new PostManager($postRepo);
        }
        return $this->postManager;
    }

    private function getUserController(): UserController
    {
        if ($this->userController === null) {
            $this->userController = new UserController($this->twigService);
        }
        return $this->userController;
    }

    private function getCommentController(): CommentController
    {
        if ($this->commentController === null) {
            $this->commentController = new CommentController($this->getCommentManager(), $this->twigService);
        }
        return $this->commentController;
    }

    private function getPostController(): PostController
    {
        if ($this->postController === null) {
            $this->postController = new PostController($this->getPostManager(), $this->getCommentManager(), $this->twigService, $this->getUserManager());
        }
        return $this->postController;
    }

    private function getAdminController(): AdminController
    {
        if ($this->adminController === null) {
            $this->adminController = new AdminController($this->getCommentManager(), $this->twigService, $this->getUserManager());
        }
        return $this->adminController;
    }

    private function getContactController(): ContactController
    {
        if ($this->contactController === null) {
            $this->contactController = new ContactController($this->twigService);
        }
        return $this->contactController;
    }

    private function getElementsController(): ElementsController
    {
        if ($this->elementsController === null) {
            $this->elementsController = new ElementsController($this->twigService);
        }
        return $this->elementsController;
    }

    public function run(string $uri)
    {
        // var_dump($_SESSION);
        $path = explode('?', $uri)[0];
        $isMethodPost = $_SERVER['REQUEST_METHOD'] === 'POST';

        // Récupérer l'ID de l'URL s'il est présent
        $queryString = explode('?', $uri)[1] ?? '';
        $id = intval($queryString);
        $id = ($id === 0 && $queryString !== "0") ? null : $id;

        switch ($path) {
            case '/':
                $this->getElementsController()->showIndex();
                break;
            case '/action':
                $this->getElementsController()->showDynamicDialog();
                break;
            case '/contact':
                if ($isMethodPost) {
                    $this->getContactController()->sendEmail();
                } else {
                    $this->getElementsController()->showFormContact();
                }
                break;
            case '/blog':
                if ($id !== null) {
                    $this->getPostController()->displayOnePost($id);
                } else {
                    $this->getPostController()->displayGallery();
                }
                break;
            case '/auth':
                $url = $this->backUrl();
                if ($isMethodPost) {
                    $this->getUserController()->showAuth();
                }
                $this->getElementsController()->showLoginDialogue($url);
                break;
            case '/register':
                if ($isMethodPost) {
                    $this->getUserController()->addOneUser();
                }
                break;
            case '/comment/add':
                if ($isMethodPost) {
                    $this->getCommentController()->addComment();
                } else {
                    echo "Erreur: méthode non autorisée.";
                }
                break;
            case '/Comment/delete':
                if ($isMethodPost) {
                    $this->getCommentController()->deleteComment();
                }
                break;
            case '/Comment/update':
                if ($isMethodPost) {
                    $this->getCommentController()->updateComment();
                }
                break;
            case '/admin':
                $this->getAdminController()->dashboardAdmin();
                break;
            case '/Comment/put':
                $this->getCommentController()->publishComment();
                break;
            case '/Post/post':
                if ($isMethodPost) {
                    $this->getPostController()->createOnePost();
                }
                break;
            case '/Post/delete':
                if ($isMethodPost) {
                    $this->getPostController()->deleteOnePost();
                }
                break;
            case '/Post/put':
                if ($isMethodPost) {
                    $this->getPostController()->updateOnePost();
                }
                break;
            case '/logOut':
                $this->getUserManager()->logOut();
                break;
            default:
                $this->getElementsController()->showPage404();
                break;
        }
    }

    public function backUrl()
    {
        $current_url = $_SERVER['HTTP_REFERER'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['last_url'] = $_POST['current_url'];
            $current_url = $_SESSION['last_url'];
        }
        return $current_url;
    }
}
