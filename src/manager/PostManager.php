<?php

namespace App\manager;
use App\repository\PostRepository;
// use App\service\DatabaseService;


class PostManager {


    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;

    }

    public function getAll(): array {
   
        $posts = $this->postRepository->getPosts();
        return $posts;
    }

}