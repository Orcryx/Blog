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
                //Ajouter au model du commentaire une valeur IsOwner (pour chaque commentaire)
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

        // Utilisation de filter_input pour récupérer et valider les entrées
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $message = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
        $userId = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);

        // Validation des données
        if (empty($title) || empty($message)) {
            echo $this->twigService->render(
                'message.twig',
                ['message' => 'Le titre et le contenu sont obligatoires.', 'origin' => $environnement]
            );
            return;
        } else {
            $date = new \DateTime();
            $createdAt = $date->format('Y-m-d H:i:s');
            $this->postManager->createOnePost($title, $message, $userId, $createdAt);
            echo $this->twigService->render(
                'message.twig',
                ['message' => 'Article ajouté', 'origin' => $environnement]
            );
        }
    }

    public function deleteOnePost(): void
    {
        $environnement = "/blog";

        // Utilisation de filter_input pour valider l'ID du post
        $postId = filter_input(INPUT_POST, 'postId', FILTER_VALIDATE_INT);

        if ($postId !== false && $postId !== null) {
            $message = "L'article a été supprimé";
            $this->postManager->deletePostById($postId);
        } else {
            $message = "Erreur: référence article introuvable.";
        }

        echo $this->twigService->render(
            'message.twig',
            ['message' => $message, 'origin' => $environnement]
        );
    }

    public function updateOnePost(): void
    {
        $environnement = $this->userService->getEnvironnement($_SESSION['previous_url']);

        // Récupérer les données POST avec validation
        $postId = filter_input(INPUT_POST, 'postId', FILTER_VALIDATE_INT);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $message = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($postId && $title && $message) {
            $this->postManager->updateOnePostById($postId, $title, $message);
            $message = "Article mis à jour avec succès.";
        } else {
            $message = "Echec de la requête.";
        }

        echo $this->twigService->render(
            'message.twig',
            ['message' => $message, 'origin' => $environnement]
        );
    }
}
