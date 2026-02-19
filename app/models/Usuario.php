<?php
require_once "MainModel.php";

class Usuario extends MainModel {

    //Crear usuario 
    public function crearUsuario($identificacion, $nombre, $apellido, $email, $telefono, $password, $rol) {
        $sql = "INSERT INTO usuarios (identificacion, nombre, apellido, email, telefono, password, rol_fk)
                VALUES (:identificacion, :nombre, :apellido, :email, :tel, :pass, :rol)";
        
        $params = [
            ':identificacion' => $identificacion,
            ':nombre' => $nombre,
            ':apellido'   => $apellido,
            ':email' => $email,
            ':tel' => $telefono,
            ':pass' => $password,
            ':rol' => $rol
        ];

        return $this->query($sql, $params);
    }

    // Actualizar información básica del usuario
    public function actualizarUsuario($id, $nombre, $apellido, $telefono, $correo, $estado) {
        $sql = "UPDATE usuarios 
                SET nombre = :nombre, apellido = :apellido, telefono = :tel, email = :correo, activo = :estado
                WHERE id = :id";
        $params = [
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':tel' => $telefono,
            ':id' => $id, 
            ':correo' => $correo,
            ':estado' => $estado
        ];
        return $this->query($sql, $params);
    }

    // Obtener todos los usuarios con su rol (usando un JOIN)
    public function listarUsuarios() {
        $sql = "SELECT u.id,
                        u.identificacion,
                        u.nombre,
                        u.apellido,
                        u.email,
                        u.telefono,
                        u.fecha_registro,
                        u.activo AS estado,
                        r.nombre AS rol
                FROM usuarios u 
                INNER JOIN roles r ON u.rol_fk = r.id
                WHERE r.id = :rol";
        return $this->table($sql, [':rol'=>2]);
    }

    // Verificar si ya existe una identificación
    public function verificarIdentificacion($identificacion) {
        $sql = "SELECT id FROM usuarios WHERE identificacion = :identificacion";
        return $this->row($sql, [':identificacion' => $identificacion]);
    }

    //Verificar si ya existe un correo
    public function verificarCorreo($correo) {
        $sql = "SELECT id FROM usuarios WHERE email = :correo";
        return $this->row($sql, [':correo' => $correo]);
    }

    //Actualizar contraseña
    public function actualizarPassword($id, $newPassword) {
        $sql = "UPDATE usuarios SET password = :pass WHERE id = :id";
        return $this->query($sql, [':pass' => $newPassword, ':id' => $id]);
    }

    //Buscar usuario por correo 
    public function obtenerPorCorreo($correo) {
        $sql = "SELECT * FROM usuarios WHERE email = :correo LIMIT 1";
        return $this->row($sql, [':correo' => $correo]);
    }

    //Obtener id de un usuario
    public function getIdUsuario($correo){
        $sql = "SELECT id FROM usuarios WHERE email = :correo";

        return $this->row($sql, [':correo' => $correo]);
    }

    //Cambiar estado de usuario 
    public function cambiarEstado($id_usuario, $estado){
        $sql = "UPDATE usuarios 
                SET activo=:estado
                WHERE id=:id_usuario"; 

        $params = [
            ':estado' => $estado,
            ':id_usuario' => $id_usuario
        ];

        return $this->query($sql, $params);
    }

    //Buscar usuarios por nombre o apellido 
    public function BuscarUsuario($nombre, $apellido){
        $sql = "SELECT u.identificacion,
                        u.nombre,
                        u.apellido,
                        u.email,
                        u.telefono,
                        u.activo AS estado,
                        r.nombre AS rol
                FROM usuarios u 
                INNER JOIN roles r ON u.rol_fk = r.id
                WHERE u.nombre LIKE :nombre OR u.apellido LIKE :apellido"; 

        $params = [
            ':nombre' => '%'.$nombre.'%',
            ':apellido' => '%'.$apellido.'%'
        ];

        return $this->table($sql, $params);
    }

    public function obtenerUsuariosActivos(){
        $sql = "SELECT u.id,
                        u.identificacion,
                        u.nombre,
                        u.apellido,
                        u.email,
                        u.telefono,
                        u.fecha_registro,
                        u.activo,
                        r.nombre AS rol
                FROM usuarios u 
                INNER JOIN roles r ON u.rol_fk = r.id
                WHERE r.id = :rol AND u.activo = :activo";

        return $this->table($sql, [':rol'=>2, ':activo' => 1]);
    
    }
}