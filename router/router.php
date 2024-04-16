<?php

namespace router;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Router
{
    private array $routes;
    private Environment $twig;

    //constructeur de la class routeur
    public function __construct()
    {
        $loader = new FilesystemLoader('../src/view');
        $this->twig = new Environment($loader);
    }

    public function get(string $path, array $action):void
    {
        $this->routes[$path] = $action;
    }

    public function run(string $uri)
    {
        $path = explode('?', $uri)[0];
        //aller chercher l'action dans le tableau, la stocker dans la variable action si la route est différente de null (null=chemin non défini)
        $action = $this->routes[$path] ?? null;
        //vérifier si le tableau avec le namespace/**  existe
        if(is_array($action)) {
            //instancier la class puis appeller la méthode lorsque c'est un tableau 
            [$class, $method] = $action;
            if (class_exists($class) && method_exists($class,$method)) {
            //on exécute le code si : la class existe et si la méthode existe dans la class passée dans l'action - dans [] : les éventuels arguments après le ?
                $class = new $class;
                return call_user_func_array([$class,$method], []);
       
            }
           
        }else {
            //sinon retourner la vue 404 
            http_response_code(404);
            echo $this->twig->render('404.twig'); 
        }
        
       
    }
}