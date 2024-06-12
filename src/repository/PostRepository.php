<?php

namespace App\repository;
use App\service\DatabaseService;

class PostRepository {

         private DatabaseService $databaseService;

        public function __construct( DatabaseService $databaseService) {
              //Init connexion à la base de données
            $this->databaseService = $databaseService;
        }

    function getPosts():array{
    
        $posts = $this->databaseService->query('SELECT * FROM post');
        return $posts;
    }
}  


