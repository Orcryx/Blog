<?php

namespace App\manager;

use App\model\PostModel;
use App\repository\PostRepository;


class PostManager {

    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAll(): array {
   
        $postsEntities = $this->postRepository->getPosts();
        // $tableau = [
        //     [
        //         "postId"=>"",
        //         "postVar"=>""
        //     ],
        //     [
        //         "postId"=>"",
        //         "postVar"=>""
        //     ],
        //     [
        //         "postId"=>"",
        //         "postVar"=>""
        //     ]
        // ];

        $postsModel= PostModel::createFromEntities($postsEntities);

       //TODO : $post=PostModel::createFromEntity($tableau[0]);
        return $postsModel;
      
    }

}