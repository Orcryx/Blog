<?php

namespace App\model;

use App\manager\CommentManager;

class CommentModel
{
    // protected int $commentId;
    private string $comment;
    private int $postId;
    private string $nickname;
    private int $userId;
    public bool $isOwner = false;


    // bool $isValidated
    public function __construct(
        public readonly int $commentId,
        string $comment,
        int $postId,
        string $nickname,
        int $userId
    ) {

        //$this->commentId = $commentId;
        $this->comment = $comment;
        $this->postId = $postId;
        $this->nickname = $nickname;
        $this->userId = $userId;
    }


    //Créer un post avec les donnnées de la BD et des données construites
    //  /**
    //  * @return CommentModel[]
    // */
    public static function createFromEntities(array $commentEntities): array
    {
        $commentModelsNoValidated = [];

        foreach ($commentEntities as $commentEntity) {
            $commentModelsNoValidated[] = new self(
                $commentEntity->commentId,
                $commentEntity->comment,
                $commentEntity->postId,
                $commentEntity->nickname,
                $commentEntity->userId
            );
        }
        return  $commentModelsNoValidated;
    }

    // Getters
    public function getCommentId(): int
    {
        return $this->commentId;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getPostId(): int
    {
        return $this->postId;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
