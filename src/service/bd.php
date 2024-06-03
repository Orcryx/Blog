<?php
//phpinfo();

//connexion à la base de données
$host = 'web-lame.home';
$dbname = 'blog';
$username = 'root';
$password = 'GyA5ShSyTj2paFknmC';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

