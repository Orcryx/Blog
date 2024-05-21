<?php
namespace controller;

class home
{
    public function getHome()
    {
        require_once(__DIR__ . "/../lib/twig.php");
        return $twig->render('index.twig');
    }
}