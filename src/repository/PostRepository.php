<?php

namespace App\repository;
use App\service\DatabaseService;

class PostRepository {

         private DatabaseService $databaseService;

        public function __construct( DatabaseService $databaseService) {
              //Init connexion à la base de données
            $this->databaseService = $databaseService;
        }

   public function getPosts():array{
    
        $posts = $this->databaseService->query('SELECT * FROM post');
        return $posts;
    }

    public function getOnePost(int $id):array{
    
        $onePost = $this->databaseService->prepareAndExecute('SELECT * FROM post WHERE postId = :id', ['id' => $id]);
        return $onePost ? $onePost[0] : []; // Retourne le premier élément ou un tableau vide si aucun résultat
    }



}  


