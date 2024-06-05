<?php

namespace App\service;

class Router
{
    private array $routes;
    private int $arg;
    private TwigService $twigService;

    //constructeur de la class routeur
    public function __construct()
    {
        $this->twigService = new TwigService();
    }

    public function get(string $path, array $action):void
    {
        $this->routes[$path] = $action;
    }

    public function getOne(string $path, array $action, int $id)
    {
        $this->routes[$path] = $action;
        $this->arg = $id; 
    }

    public function run(string $uri)
    {
        $path = explode('?', $uri)[0];
       // var_dump($path) ;

        // Récupérer l'ID de l'URL s'il est présent
        $queryString = explode('?', $uri)[1] ?? ''; // Obtenir la partie de la chaîne après le '?'
        parse_str($queryString, $queryParams); // Convertir la chaîne de requête en tableau de paramètres
        $id = $queryParams['id'] ?? null; // Récupérer la valeur de 'id' s'il est présent


        //aller chercher l'action dans le tableau, la stocker dans la variable action si la route est différente de null (null=chemin non défini)
        $action = $this->routes[$path] ?? null;
        //var_dump($action);
        //vérifier si le tableau avec le namespace/**  existe
        if(is_array($action)) {
            //instancier la class puis appeller la méthode lorsque c'est un tableau 
            [$class, $method] = $action;
            // var_dump($class) ;
            // var_dump($method) ;
            if (class_exists($class) && method_exists($class,$method)) {
                $class = new $class;

                if ($id !== null) {
                    echo $id;
                   // $method ='getPost';
                    return call_user_func_array([$class, $method], $id);
                } else {
                     //on exécute le code si : la class existe et si la méthode existe dans la class passée dans l'action - dans [] : les éventuels arguments après le ?
                    return call_user_func([$class, $method],[]);
                }
                // return call_user_func_array([$class,$method],[]);  
            }  
        }else {
            //sinon retourner la vue 404 
            http_response_code(404);
            echo $this->twigService->twigEnvironnement->render('404.twig'); 
        }
    }
}