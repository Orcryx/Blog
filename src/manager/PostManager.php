<?php

namespace App\manager;
use App\repository\PostRepository;
use App\service\DatabaseService;

class PostManager {


    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;

    }

    public function getAll(): array {
   
        $posts = $this->postRepository->getPosts();
            //todo / TRANSFORMER $posts en un tableau de postModel ref ligne 56
        // $postObjects = [];
        // foreach ($posts as $post) {
        //     $postObjects[] = self::createFromEntity($post);
        // }

         return $posts;
    }

}