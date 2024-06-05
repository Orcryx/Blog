<?php

namespace App\repository;
use App\service\DatabaseService;

class PostRepository {

    function getPosts():array{
    
        //Init connexion à la base de données
        $bd = new DatabaseService();
        $posts = $bd->query('SELECT * FROM post');
        return $posts;
    }

}  


