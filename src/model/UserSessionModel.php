<?php

namespace App\model;


class UserSessionModel{
    
    public bool $isOwer = false;

    public function __construct(public readonly int $userId, public readonly string $email, public readonly string $role, public readonly string $nickname)
    {
     
    }
    public function isOwer(int $id) : bool
    {
     if ($this->userId === $id) {
            return  $this->isOwer = true;
        }
        else
        {
            return $this->isOwer = false;
        }
       
    }

    public function IsAdmin () : bool{
        if ($this->role == UserModel::ROLE_ADMIN) {
            return true;
        }else
        {
            return false;
        }
    }

    public function setIsOwner(bool $isOwner): void {
        $this->isOwer = $isOwner;
    }

}