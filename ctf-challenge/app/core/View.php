<?php
namespace App\Core;

class View {
    private $data = [];

    public function set($key, $value) {
        $this->data[$key] = $value;
    }

    public function render($viewPath) {
        // Extraire les données pour qu'elles soient disponibles dans la vue
        extract($this->data);
        
        // Inclure la vue
        require dirname(__DIR__) . '/views/' . $viewPath;
    }
} 