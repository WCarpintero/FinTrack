<?php 
require_once 'MainModel.php';

class Login extends MainModel{
    public function autenticar($email, $password) {
        // 1. Buscamos al usuario por correo
        $sql = "SELECT id, nombre, apellido, password, activo, rol_fk 
                FROM usuarios 
                WHERE email = :email 
                LIMIT 1";
        
        $usuario = $this->row($sql, [':email' => $email]);

        // 2. Si el usuario existe y está activo
        if ($usuario && $usuario['activo'] == 1) {

            // Si existe el usuario, verificamos la contraseña hasheada
            if ($usuario && password_verify($password, $usuario['password'])) {
                // La contraseña es correcta, devolvemos el usuario
                return $usuario;
            }
        }

        // Si algo falla (no existe, inactivo o mal password)
        return false;
    }


}