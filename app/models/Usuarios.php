<?php

class Usuario extends Model{
    //Registrar un nuevo usuario
    public function registrarUsuario($data){
        $sql = "INSERT INTO usuarios(nombres, apellidos, email, telefono, password, rol_id)
                VALUES (:nombres, :apellidos, :email, :telefono, :password, :rol_id)";

        $params = [
            ':nombres' => $data['nombres'],
            ':apellidos' => $data['apellidos'],
            ':email' => $data['email'],
            ':telefono' => $data['telefono'],
            ':password' => password_hash($data['password'], PASSWORD_BCRYPT),
            ':rol_id' => $data['rol_id']
        ];

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    //Validar usuarios para el login
    public function validarUsuario($email, $password){
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();

        if($usuario && password_verify($password, $usuario['password'])){
            return $usuario;
        }
        return false;
    }

    //Validar si el usuario ya está registrado por su udentificación
    public function usuarioExiste($identificacion){
        $sql = "SELECT COUNT(*) FROM usuarios WHERE identificacion = :identificacion";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':identificacion' => $identificacion]);
        return $stmt->fetchColumn() > 0;
    }

    //Validar si el email ya está registrado
    public function emailExiste($email){
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    //Actuyalizar datos del usuario
    public function actualizarPerfil($id, $data) {
        $sql = "UPDATE usuarios SET nombres = :nombre, email = :email, apellidos = :apellidos, telefono = :telefono  WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'nombre' => $data['nombre'],
            'email'  => $data['email'],
            'apellidos' => $data['apellidos'],
            'telefono' => $data['telefono'],
            'id'     => $id
        ]);
    }

    //Buscar usuario 
    public function buscarUsuario($id) {
        $sql = "SELECT u.identificacion,
                        u.nombres,
                        u.apellidos, 
                        u.email,
                        u.telefono, 
                        u.estado,
                        r.nombre AS rol
                FROM usuarios u
                INNER JOIN roles r ON r.id=u.rol_id
                WHERE u.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    //Cambiar estado de un usuario (activo/inactivo)
    public function cambiarEstado($id, $estado) {
        $sql = "UPDATE usuarios SET estado = :estado WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'estado' => $estado,
            'id'     => $id
        ]);
    }

    //Listar usuarios 
    public function listarUsuarios(){
        $sql = "SELECT u.identificacion,
                        u.nombres,
                        u.apellidos, 
                        u.email,
                        u.telefono, 
                        u.estado,
                        r.nombre AS rol
                FROM usuarios u
                INNER JOIN roles r ON r.id=u.rol_id";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    //Cambiar contraseña del usuario
    public function cambiarPassword($id, $nuevaPassword) {
        $sql = "UPDATE usuarios SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'password' => $nuevaPassword,
            'id'       => $id
        ]);
    }

    // Eliminar un usuario
    public function eliminarUsuario($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}