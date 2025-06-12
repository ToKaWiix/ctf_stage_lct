<?php
namespace Anna\CtfChallenge\Core;

require_once dirname(__DIR__) . '/core/database.php';

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
            // Obtenir la connexion PDO
            $pdo = getPDO();
            
            // Instancier le contrôleur avec la connexion PDO
            $controller = new $controllerClass($pdo);

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
