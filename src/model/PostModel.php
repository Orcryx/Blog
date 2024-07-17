<?php
namespace App\model;
use App\manager\PostManager;

class PostModel{
    private int $postId;
    private string $title;
    private string $message;
    private string $chapo;
    private int $userId;
    private string $createdAt;


    public function __construct(int $postId, string $title, string $message, string $chapo, int $userId, string $createdAt)
    {
       
        $this->postId = $postId;
        $this->title = $title;
        $this->chapo = $chapo;
        $this->userId = $userId;
        $this->message = $message;
        $this->createdAt = $createdAt;
    }


    //Créer un post avec les donnnées de la BD et des données construites
     /**
      * @param PostEntity[] : pour plus tard
     * @return PostModel[]
    */
    public static function createFromEntities(array $postEntities): array {
        $postModels=[];

        foreach ($postEntities as $postEntity) 
        {
            // Construction de la date au format français
            $createdAt = date("d/m/Y", strtotime($postEntity->createAt));
            
            // Récupération des 20 premières lignes du contenu (chapo)
        
            $chapo = strlen($postEntity->message) > 100 ? substr($postEntity->message, 0, 100) . '...' : $postEntity->message;

           $postModels[] = new self(
                $postEntity->postId,
                $postEntity->title,
                $postEntity->message,
                $chapo,
                $postEntity->userId,
                $createdAt
            );
        }
        return $postModels;
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

    public function getChapo(): string {
        return $this->chapo;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }
}