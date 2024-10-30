<?php

namespace App\manager;

use App\model\PostModel;
use App\model\ArticleModel;
use App\repository\PostRepository;
use App\model\UserSessionModel;

class PostManager
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAll(): array
    {
        $postsEntities = $this->postRepository->getPosts();
        $postsModel = PostModel::createFromEntities($postsEntities);
        return $postsModel;
    }


    public function getOne(int $id): ArticleModel
    {
        $postEntity = $this->postRepository->getOnePost($id);
        $articleModel = ArticleModel::createFromEntity($postEntity);
        return $articleModel;
    }


    public function isOwner(int $postId, UserSessionModel $userSession): bool
    {
        $postEntity = $this->postRepository->getOnePost($postId);
        if ($postEntity) {
            return $userSession->isOwer($postEntity->userId);
        }
        return false;
    }

    public function createOnePost(string $title, string $message, int $userId, string $createdAt): void
    {
        $this->postRepository->createOnePost($title, $message, $userId, $createdAt);
    }

    public function deletePostById(int $postId): void
    {
        $this->postRepository->deletePostById($postId);
    }

    public function updateOnePostById(int $postId, string $title, string $message): void
    {
        $this->postRepository->updateOnePostById($postId, $title, $message);
    }
}
