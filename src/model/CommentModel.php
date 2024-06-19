<?php
namespace App\model;
use App\manager\CommentManager;

class CommentModel{
    private int $commentId;
    private string $comment;
   // private bool $isValidated;
    private int $userId;
    private int $postId;


    // bool $isValidated
    public function __construct(int $commentId, string $comment, int $userId, int $postId)
    {
       
        $this->commentId = $commentId;
        $this->comment = $comment;
       // $this->isValidated = $isValidated;
        $this->userId = $userId;
        $this->postId = $postId;
    }


    //Créer un post avec les donnnées de la BD et des données construites
     /**
     * @return CommentModel[]
    */
    public static function createFromEntities(array $commentEntities): array {
        $commentModels=[];

        foreach ($commentEntities as $comment) {
            # code...
            $commentsModel[] = new self(
                $comment['commentId'],
                $comment['comment'],
                $comment['userId'],
                $comment['postId'],
            );
        }
           
        return  $commentModels;
    }
    
    // Getters
    public function getCommentId(): int {
        return $this->commentId;
    }

    public function getComment(): string {
        return $this->comment;
    }

    // public function getIsValidated(): bool {
    //     return $this->isValidated;
    // }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getPostId(): int {
        return $this->postId;
    }
}