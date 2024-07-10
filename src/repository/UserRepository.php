<?php

namespace App\repository;
use App\service\DatabaseService;

class UserRepository{

    private DatabaseService $databaseService; 

    public function __construct(DatabaseService $databaseService)
    {
        //initialiser la connexion à la bse de données dans l'objet
        $this->databaseService = $databaseService;
    }


      /**
     * @return array|null
     */
    public function getUserByEmail(string $email) : array|null{
        $user = $this->databaseService->prepareAndExecute('SELECT * FROM user WHERE email = :email' , ['email' => $email] );
        if (empty($user)) {
            return null;
        }
        return $user;
    }
}