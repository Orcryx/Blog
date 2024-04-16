<?php
namespace controller;

class page404
{
    public function get404()
    {
        require"init.php";
        return $twig->render('404.twig');
    }
}