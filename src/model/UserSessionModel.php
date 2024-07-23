<?php

namespace App\model;

class UserSessionModel{
    
    public bool $isower = false;

    public function __construct(public readonly int $userId, public readonly string $email, public readonly string $role, public readonly string $nickname)
    {
     
    }
    public function isOwer(int $id) : bool
    {
     if ($this->userId === $id) {
            return  $this->isower = true;
        }
        else
        {
            return $this->isower = false;
        }
       
    }

    public function setIsOwner(bool $isOwner): void {
        $this->isower = $isOwner;
    }

}