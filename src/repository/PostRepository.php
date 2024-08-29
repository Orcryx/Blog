<?php

namespace App\repository;
use App\service\DatabaseService;

class PostRepository {

         private DatabaseService $databaseService;

        public function __construct( DatabaseService $databaseService) {
              //Init connexion à la base de données
            $this->databaseService = $databaseService;
        }

        /**
         * @return array
        */
        public function getPosts():array
            {
                $postsObj = $this->databaseService->query('SELECT * FROM post');
                return $postsObj;
            }

    
    public function getOnePost(int $id):object{
    
        $onePost = $this->databaseService->prepareAndExecuteOne('SELECT * FROM post WHERE postId = :id', ['id' => $id]);
        return $onePost ;
    }



}  


