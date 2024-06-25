<?php
namespace App\model;
use App\manager\CommentManager;

class CommentModel{
    private int $commentId;
    private string $comment;
   // private bool $isValidated;
    // private int $userId;
    private int $postId;
    private string $userName;
    private string $firstName;


    // bool $isValidated
    public function __construct(int $commentId, string $comment, int $postId, string $userName, string $firstName)
    {
       
        $this->commentId = $commentId;
        $this->comment = $comment;
        $this->postId = $postId;
        $this->userName = $userName;
        $this->firstName = $firstName;
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
                $comment['name'],
                $comment['firstName'],
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

    public function getUserName(): string {
        return $this->userName;
    }

    public function getfirstName(): string {
        return $this->firstName;
    }
}