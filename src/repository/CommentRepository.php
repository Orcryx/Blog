<?php

namespace App\repository;
use App\service\DatabaseService;

class CommentRepository {

         private DatabaseService $databaseService;

        public function __construct( DatabaseService $databaseService) {
              //Init connexion à la base de données
            $this->databaseService = $databaseService;
        }

    public function getValidatedCommentByPostId(int $postId):array{
    
        $comments = $this->databaseService->prepareAndExecute('SELECT comment.commentId, comment.comment, comment.isValidated, comment.postId, comment.userId, user.nickname FROM comment JOIN user ON comment.userId = user.userId WHERE comment.postId = :postId AND comment.isValidated ="1" ', ['postId' => $postId]);
        return $comments ;
    }

    public function createCommentByPostId(int $postId, string $comment, int $userId, int $isValidated): void {
        // Définir les valeurs par défaut pour isValidated et role
        $isValidated = 0; // par exemple, 0 pour non validé
        $params = [
            ':comment' => $comment,
            ':isValidated' => $isValidated,
            ':userId' => $userId,
            ':postId' => $postId
        ];

        $newcomment = $this->databaseService->prepareAndExecute('INSERT INTO comment (comment, isValidated, userId, postId) VALUES (:comment, :isValidated, :userId, :postId)',$params);
        if ($newcomment === false) {
            echo"Echec de la requête SQL Insert Into";
            exit;
        }
    }

    public function getCommentById(int $commentId): object {
        $comment = $this->databaseService->prepareAndExecuteOne('SELECT comment.commentId, comment.comment, comment.isValidated, comment.postId, comment.userId, user.nickname FROM comment JOIN user ON comment.userId = user.userId WHERE comment.commentId = :commentId', ['commentId' => $commentId]);
        return $comment ;
    }

    public function deleteCommentById(int $commentId): void {
        $comment = $this->databaseService->prepareAndExecuteOne('DELETE FROM comment WHERE comment.commentId = :commentId', ['commentId' => $commentId]);
        // return $comment ;
    }
    public function updateCommentById(int $commentId, string $comment): void {
        $comment = $this->databaseService->prepareAndExecuteOne('UPDATE comment SET comment = :comment WHERE commentId = :commentId', ['commentId' => $commentId, 'comment'=> $comment]);
    }

    public function getNoValidatedComment():array{
    
        $comments = $this->databaseService->query('SELECT comment.commentId, comment.comment, comment.isValidated, comment.postId, comment.userId, user.nickname FROM comment JOIN user ON comment.userId = user.userId WHERE comment.isValidated = "0" ');        
        return $comments ;
    }

    public function publishCommentById(int $commentId): void {
        $isValidated = 1; 
        $comment = $this->databaseService->prepareAndExecuteOne('UPDATE comment SET isvalidated = :isValidated  WHERE comment.commentId = :commentId',  ['isValidated' => $isValidated, 'commentId' => $commentId]);
        // return $comment ;
    }
}  