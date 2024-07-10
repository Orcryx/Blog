<?php

namespace App\service;
use \PDO;

class DatabaseService{

    private readonly string $db_name;
    private readonly string $db_user;
    private readonly string $db_pass;
    private readonly string $db_host;
    private ?PDO $pdo = null;

    public function __construct()
    {
        //relier les variables de la class aux valeurs passées en paramètre 
        $this->db_name =  $_ENV["DB_NAME"];
        $this->db_user = $_ENV["DB_USER"];
        $this->db_pass =  $_ENV["DB_PASS"];
        $this->db_host=  $_ENV["DB_HOST"]; 
    }

    private function getPDO():PDO
    {
        //créer un accesseur pour éviter d'avoir plusieurs fois la connexion à la base de données
        if ($this->pdo === null) {
            $dsn = "mysql:host={$this->db_host};dbname={$this->db_name}";
            $pdo = new PDO($dsn, $this->db_user, $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

    public function query($statement){
        //on a besoin de récupérer PDO
        $req = $this->getPDO()->query($statement);
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;

    }

    public function prepareAndExecute(string $statement, array $params): array
    {
        $stmt = $this->getPDO()->prepare($statement);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    
    public function prepareAndExecuteOne(string $statement, array $params): array
    {
        $stmt = $this->getPDO()->prepare($statement);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function prepareAndExecuteOneObject(string $statement, array $params): object
    {
        $stmt = $this->getPDO()->prepare($statement);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}