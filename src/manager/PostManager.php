<?php

namespace App\manager;

use App\model\PostModel;
use App\model\ArticleModel;
use App\repository\PostRepository;


class PostManager {

    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAll(): array {
        $postsEntities = $this->postRepository->getPosts();
        $postsModel= PostModel::createFromEntities($postsEntities);
        return $postsModel;
    }

 
    public function getOne(int $id): ArticleModel {
        $postEntity = $this->postRepository->getOnePost($id);
        //var_dump($postEntity );
        $articleModel = ArticleModel::createFromEntity($postEntity);
        //var_dump( $postModel);
        return $articleModel;
    }

}