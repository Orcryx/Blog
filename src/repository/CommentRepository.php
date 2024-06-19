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
    
        $comments = $this->databaseService->prepareAndExecute('SELECT * FROM comment WHERE postId = :postId AND isValidated ="1"', ['postId' => $postId]);
        return $comments ;
    }



}  