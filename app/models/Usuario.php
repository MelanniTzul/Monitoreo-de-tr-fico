<?php

namespace models;
require_once __DIR__ . '/../config/config.php';

class Usuario
{
    private $conn;

    public function __construct()
    {
        global $mysqli;
        $this->conn = $mysqli;
    }

    public function login($username, $password)
    {
        $stmt = $this->conn->prepare("
        SELECT u.*, r.Nombre AS Rol 
        FROM Usuario u
        JOIN Rol r ON u.IdRol = r.Id
        WHERE u.Username = ?
    ");
        $stmt->bind_param('s', $username);
        $stmt->execute();

        $usuario = $stmt->get_result()->fetch_assoc();
        if ($usuario && password_verify($password, $usuario['Password'])) {
            return $usuario;
        }

        return null;
    }


    public function create($nombre, $apellido, $username, $password, $idRol)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO Usuario (Nombre, Apellido, Username, Password, IdRol, Activo, FechaCreacion)
             VALUES (?, ?, ?, ?, ?, 1, NOW())"
        );
        $hashedPass = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param('ssssi', $nombre, $apellido, $username, $hashedPass, $idRol);
        return $stmt->execute();
    }

    public function getAll()
    {
        $result = $this->conn->query("SELECT * FROM Usuario WHERE Activo = 1 ORDER BY FechaCreacion DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Usuario WHERE Id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $nombre, $apellido, $username, $password, $idRol)
    {
        $stmt = $this->conn->prepare(
            "UPDATE Usuario SET 
                 Nombre = ?, 
                 Apellido = ?, 
                 Username = ?, 
                 Password = ?, 
                 IdRol = ?, 
                 FechaActualizacion = NOW()
             WHERE Id = ?"
        );
        $hashedPass = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param('ssssii', $nombre, $apellido, $username, $hashedPass, $idRol, $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("UPDATE Usuario SET Activo = 0 WHERE Id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function getRoles()
    {
        $result = $this->conn->query("SELECT Id, Nombre FROM Rol ORDER BY Nombre ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
