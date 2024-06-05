<?php

namespace App\service;
use \PDO;

class Database{

    private string $db_name;
    private string $db_user;
    private string $db_pass;
    private string $db_host;
    private ?PDO $pdo = null;

    public function __construct($db_name="blog", $db_user="root", $db_pass="GyA5ShSyTj2paFknmC", $db_host="web-lame.home" )
    {
        //relier les variables de la class aux valeurs passées en paramètre 
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host=$db_host;   
    }

    private function getPDO():PDO
    {
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
}