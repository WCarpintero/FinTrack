<?php
session_start();

// 2. Autoload dinámico: Carga automáticamente archivos de Core y Models
spl_autoload_register(function ($className) {
    // Definimos las rutas donde buscar clases
    $paths = [
        __DIR__ . '/../app/core/',
        __DIR__ . '/../app/models/',
        __DIR__ . '/../app/controllers/',
        __DIR__ . '/../app/helpers/'
    ];

    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});


$app = new Router();