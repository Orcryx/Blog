<?php
namespace App\model;
use App\manager\PostManager;

class ArticleModel{
    private int $postId;
    private string $title;
    private string $message;
    private int $userId;
    private string $date;


    public function __construct(int $postId, string $title, string $message, int $userId, string $date)
    {
       
        $this->postId = $postId;
        $this->title = $title;
        $this->userId = $userId;
        $this->message = $message;
        $this->date = $date;
    }

    //TODO : créer une fonction createFromEntity(array $postEntity) qui retourn un ArticleModel!
    
    public static function createFromEntity(object $postEntity): ArticleModel {
     
        // Construction de la date au format français
        $date = date("d/m/Y", strtotime($postEntity->createAt));
        
        // Ajouter l'instance de la classe au tableau $postModel
        $postModel = new self(
            $postEntity->postId,
            $postEntity->title,
            $postEntity->message,
            $postEntity->userId,
            $date
        );
      
        return $postModel;
    }

    // Getters
    public function getPostId(): int {
        return $this->postId;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getMessage(): string {
        return $this->message;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getDate(): string {
        return $this->date;
    }
}