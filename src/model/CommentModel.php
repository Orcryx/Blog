<?php
namespace App\model;
use App\manager\CommentManager;

class CommentModel{
    private int $commentId;
    private string $comment;
   // private bool $isValidated;
    // private int $userId;
    private int $postId;
    private string $nickname;


    // bool $isValidated
    public function __construct(int $commentId, string $comment, int $postId, string $nickname)
    {
       
        $this->commentId = $commentId;
        $this->comment = $comment;
        $this->postId = $postId;
        $this->nickname = $nickname;
    }


    //Créer un post avec les donnnées de la BD et des données construites
     /**
     * @return CommentModel[]
    */
    public static function createFromEntities(array $commentEntities): array {
        $commentModels=[];

        foreach ($commentEntities as $comment) {
            # code...
            $commentModels[] = new self(
                $comment['commentId'],
                $comment['comment'],
                $comment['postId'],
                $comment['nickname'],
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

    public function getPostId(): int {
        return $this->postId;
    }

    public function getNickname(): string {
        return $this->nickname;
    }

}