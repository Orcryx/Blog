<?php
namespace controller;

class home
{
    public function getHome()
    {
        require"init.php";
        return $twig->render('index.twig');
    }
}