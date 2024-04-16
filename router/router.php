<?php

namespace router;

use exception\routeNotFound;

class Router
{
    private array $routes;
    public function get(string $path, array $action):void
    {
        $this->routes[$path] = $action;
    }

    public function run(string $uri)
    {
        $path = explode('?', $uri)[0];
        //aller chercher l'action dans le tableau, stocker dans la variable action si la route est différente de null (null=chemin non défini)
        $action = $this->routes[$path] ?? null;
        //vérifier si le tableau existe
        if(is_array($action)) {
            //instancier la class puis appeller la méthode lorsque c'est un tableau 
            [$class, $method] = $action;
            if (class_exists($class) && method_exists($class,$method)) {
            //on exécute le code si : la class existe et si la méthode existe dans la class passée dans l'action - dans [] : les éventuels arguments après le ?
                $class = new $class;
                return call_user_func_array([$class,$method], []);
       
            }
           
        }else {
            //sinon retourner l'action = message d'erreur 
            http_response_code(404);
            return "404 - la page n'existe pas.";
        }
        
       
    }
}