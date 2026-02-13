<?php
//Configurar las variables de entorno que están en .env como constantes globales
class Config {
    public static function loadEnv($path) {
        if (!file_exists($path)) {
            return false;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Ignorar comentarios
            if (strpos(trim($line), '#') === 0) continue;

            // Dividir por el signo =
            list($name, $value) = explode('=', $line, 2);
            
            $name = trim($name);
            $value = trim($value, " \t\n\r\0\x0B\""); // Limpiar espacios y comillas

            // Definir como constante global si no existe
            if (!defined($name)) {
                define($name, $value);
            }
        }
    }
}