<?php
namespace Anna\CtfChallenge\Core;

class App
{
    public function run()
    {
        // Récupère les paramètres controller et action dans l'URL
        $controllerName = $_GET['controller'] ?? 'home';
        $action = $_GET['action'] ?? 'index';

        // Génère le nom complet de la classe contrôleur
        $controllerClass = 'Anna\\CtfChallenge\\Controllers\\' . ucfirst($controllerName) . 'Controller';

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();

            if (method_exists($controller, $action)) {
                $controller->$action();
            } else {
                echo "Erreur : méthode '$action' introuvable dans $controllerClass";
            }
        } else {
            echo "Erreur : contrôleur '$controllerClass' introuvable";
        }
    }
}
