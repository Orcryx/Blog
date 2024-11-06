<?php

namespace App\repository;

use App\service\DatabaseService;

class PostRepository
{
    private DatabaseService $databaseService;

    public function __construct(DatabaseService $databaseService)
    {
        //Init connexion à la base de données
        $this->databaseService = $databaseService;
    }

    /**
     * @return array
     */
    public function getPosts(): array
    {
        $postsObj = $this->databaseService->query('SELECT * FROM post');
        return $postsObj;
    }


    public function getOnePost(int $id): object
    {
        $onePost = $this->databaseService->prepareAndExecuteOne(
            'SELECT * FROM post WHERE postId = :id',
            ['id' => $id]
        );
        return $onePost;
    }


    public function createOnePost(string $title, string $message, int $userId, string $createdAt): void
    {
        $params = [
            ':title' => $title,
            ':message' => $message,
            ':userId' => $userId,
            ':createdAt' => $createdAt
        ];

        // Préparer et exécuter la requête
        $newpost = $this->databaseService->prepareAndExecute(
            'INSERT INTO post (title, message, userId, createAt) VALUES (:title, :message, :userId, :createdAt)',
            $params
        );

        if ($newpost === false) {
            echo "Echec de la requête SQL Insert Into";
        }
    }

    public function deletePostById(int $postId): void
    {
        // Supprimer d'abord tous les commentaires associés
        $this->databaseService->prepareAndExecuteOne(
            'DELETE FROM comment WHERE postId = :postId',
            ['postId' => $postId]
        );
        $post = $this->databaseService->prepareAndExecuteOne(
            'DELETE FROM post WHERE post.postId = :postId',
            ['postId' => $postId]
        );
    }

    public function updateOnePostById(int $postId, string $title, string $message): void
    {
        $post = $this->databaseService->prepareAndExecuteOne(
            'UPDATE post SET title = :title, message = :message WHERE postId = :postId',
            ['postId' => $postId, 'title' => $title, 'message' => $message]
        );
    }
}
