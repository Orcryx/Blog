<?php

namespace App\service;
use \PDO;

class DatabaseService{

    private string $db_name;
    private string $db_user;
    private string $db_pass;
    private string $db_host;
    private ?PDO $pdo = null;

    public function __construct($db_name=null, $db_user=null, $db_pass=null, $db_host=null )
    {

        // vérifier si les variables ont une valeur sinon donner cette d'environnement

        $db_name = $db_name ?? $_ENV["DB_NAME"];
        $db_user = $db_user ?? $_ENV["DB_USER"];
        $db_pass = $db_pass ?? $_ENV["DB_PASS"];
        $db_host = $db_host ?? $_ENV["DB_HOST"];

        //relier les variables de la class aux valeurs passées en paramètre 
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host=$db_host;   
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

}