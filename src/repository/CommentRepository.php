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
    
        $comments = $this->databaseService->prepareAndExecute('SELECT comment.commentId, comment.comment, comment.isValidated, comment.postId, user.name, user.firstName FROM comment JOIN user ON comment.userId = user.userId WHERE comment.postId = :postId AND comment.isValidated ="1" ', ['postId' => $postId]);
        return $comments ;
    }



}  