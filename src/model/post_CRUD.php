<?php

namespace model;
// use model\Post;
use PDO;

require_once(__DIR__ . '/../lib/bd.php');

function getAllPost($pdo) {
            $sql = 'SELECT * FROM post';
            $req = $pdo->prepare($sql);
            $req->execute();
            $post = $req->fetchAll(PDO::FETCH_ASSOC);
            
            //créer le tableau de données
            $data = [];
            foreach ($post as $post) {
                $capo =  strlen($post['message']) > 100 ? substr($post['message'], 0, 100) . '...' : $post['message'];
                $formattedDate = date('d/m/Y', strtotime($post['createAt']));
                $formattedPost = [
                    'id' => $post['postId'],
                    'title' => $post['title'],
                    'content' => $post['message'],
                    'capo'=> $capo ,
                    'date'=>$formattedDate
                ];
                $data[] = $formattedPost;
            }
            return $data;
}
$post = getAllPost($pdo);     



