<?php

namespace App\controller;

use App\manager\CommentManager;
use App\service\TwigService;
use App\manager\PostManager;
use App\service\UserService;

class PostController
{
    public function __construct(
        private readonly PostManager $postManager,
        private readonly CommentManager $commentManager,
        private readonly TwigService $twigService,
        private readonly UserService $userService
    ) {
        //contenu du constructeur
    }

    public function displayGallery()
    {
        /**@var PostModel[] $posts */
        $posts = $this->postManager->getAll();
        echo $this->twigService->render('gallery.twig', ['posts' => $posts]);
    }

    public function displayOnePost(int $postId)
    {
        $articleModel =  $this->postManager->getOne($postId);
        $commentModels = $this->commentManager->getCommentByPost($articleModel->getPostId());
        // Utilisation de UserService pour obtenir la session utilisateur
        $userSession = $this->userService->getUserSession();
        $isCommentOwner = false;
        $isPostOwner = false;
        if ($userSession !== null) {
            // Vérifier si l'utilisateur connecté est l'auteur du post
            $isPostOwner = $this->postManager->isOwner($postId, $userSession);

            // Mettre à jour l'objet UserSessionModel avec le boolean
            $userSession->setIsOwner($isPostOwner);

            // Vérifier si l'utilisateur connecté est l'auteur de chaque commentaire
            foreach ($commentModels as $commentModel) {
                $id = $commentModel->commentId;
                // Vérifier si l'utilisateur connecté est l'auteur du commentaire
                $isCommentOwner = $this->commentManager->isOwner($id, $userSession);

                //Ajouter au model du commentaire une valeur IsOwer (pour chaque commentaire)
                $commentModel->isOwner = $isCommentOwner;
            }
            // Mettre à jour la session avec l'objet modifié
            $_SESSION['user'] = $userSession;
            echo $this->twigService->render(
                'post.twig',
                ['post' => $articleModel, "comments" => $commentModels, "isAuthor" => $isPostOwner]
            );
        } else {
            echo $this->twigService->render(
                'post.twig',
                ['post' => $articleModel, "comments" => $commentModels]
            );
        }
    }


    public function createOnePost(): void
    {
        $environnement = "/admin";
        if (isset($_POST['title']) || isset($_POST['content']) || isset($_POST['userId'])) {
            // Récupérer les données du formulaire (titre, contenun, userId)
            $title = $_POST['title'] ?? null;
            $message = $_POST['content'] ?? null;
            $userId = $_POST['userId'] ?? null;

            // Validation des données
            if (empty($title) || empty($message)) {
                echo $this->twigService->render(
                    'message.twig',
                    ['message' => 'Le titre et le contenu sont obligatoires.', 'origin' => $environnement]
                );
                return;
            } else {
                $date = new \DateTime();

                // Formatage de la date au format désiré 'Y-m-d H:i:s'
                $createdAt = $date->format('Y-m-d H:i:s');
                $this->postManager->createOnePost($title, $message, $userId, $createdAt);
                echo $this->twigService->render(
                    'message.twig',
                    ['message' => 'Article ajouté', 'origin' => $environnement]
                );
            }
        } else {
            echo $this->twigService->render(
                'message.twig',
                ['message' => 'Erreur: tous les champs ne sont pas remplis.', 'origin' => $environnement]
            );
        }
    }

    public function deleteOnePost(): void
    {
        $environnement = "/blog";
        if (isset($_POST['postId'])) {
            $postId = intval($_POST['postId']);
            if (!empty($postId)) {
                $message = "l'article a été supprimé";
                $this->postManager->deletePostById($postId);
            } else {
                $message = "Echec de la requête.";
            }
        } else {
            // Affichez un message d'erreur si tous les champs requis ne sont pas remplis
            $message = "Erreur: référence article introuvable.";
        }
        // Renvoyer le message avec Twig
        echo $this->twigService->render(
            'message.twig',
            ['message' => $message, 'origin' => $environnement]
        );
    }

    public function updateOnePost(): void
    {
        $environnement = $this->userService->getEnvironnement($_SESSION['previous_url']);
        if (isset($_POST['title']) || isset($_POST['content']) || isset($_POST['postId'])) {
            // Récupérer les données du formulaire (titre, message ,postId)
            $postId = $_POST['postId'] ?? null;
            $title = $_POST['title'] ?? null;
            $message = $_POST['content'] ?? null;
            $this->postManager->updateOnePostById($postId, $title, $message);
        } else {
            $message = "Echec de la requête.";
        }
        // Renvoyer le message avec Twig
        echo $this->twigService->render(
            'message.twig',
            ['message' => $message, 'origin' => $environnement]
        );
    }
}
