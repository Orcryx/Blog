<?php
namespace controller;

class contact
{
    public function getForm()
    {
        require_once(__DIR__ . "/../lib/twig.php");
        return $twig->render('contact_include.twig');
    }
}