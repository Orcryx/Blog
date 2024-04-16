<?php
namespace controller;

class blog
{
    public function getGallery()
    {
        require"init.php";
        return $twig->render('gallery.twig');
    }
}