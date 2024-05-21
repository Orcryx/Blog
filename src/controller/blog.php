<?php
namespace controller;

class blog
{
    public function getGallery()
    {
        require_once(__DIR__ . "/../lib/twig.php");
        include(__DIR__ ."/../model/post_CRUD.php");

        // Afficher le résultat de la requête
        return $twig->render('gallery.twig',["posts"=>$post]);
    }

    public function getPost()
    { 
        require_once(__DIR__ . "/../lib/twig.php");
        return $twig->render('post.twig');
    }


}