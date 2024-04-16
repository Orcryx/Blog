<?php
namespace controller;

class contact
{
    public function getForm()
    {
        require"init.php";
        return $twig->render('contact_include.twig');
    }
}