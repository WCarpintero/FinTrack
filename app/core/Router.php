<?php

class Router {
    protected $controller = 'DashboardController'; // Controlador por defecto
    protected $method = 'index';                   // Método por defecto
    protected $params = [];                        // Parámetros de la URL

    public function __construct() {
        $url = $this->parseUrl();

        // 1. Verificar si el controlador existe en la carpeta /controllers
        if (isset($url[0]) && file_exists(__DIR__ . '/../controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        }

        require_once __DIR__ . '/../controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 2. Verificar si existe el método dentro del controlador
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 3. Obtener los parámetros restantes (si los hay)
        $this->params = $url ? array_values($url) : [];

        // 4. Llamar al método del controlador con los parámetros
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    
    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}