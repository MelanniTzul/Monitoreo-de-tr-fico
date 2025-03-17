<?php

namespace models;
require_once __DIR__ . '/../config/config.php';

class Semaforo
{
    private $conn;

    public function __construct()
    {
        global $mysqli;
        $this->conn = $mysqli;
    }

    public function getAll()
    {
        $query = "SELECT s.Id, i.Descripcion AS Interseccion, s.TiempoVerde, s.TiempoAmarillo, s.TiempoRojo, 
                         s.EstadoActual, s.Activo 
                  FROM Semaforo s
                  JOIN Interseccion i ON s.IdInterseccion = i.Id
                  WHERE s.Activo = 1";
        $result = $this->conn->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function create($idInterseccion, $tiempoVerde, $tiempoAmarillo, $tiempoRojo, $estadoActual)
    {
        // Verificar la cantidad de semáforos en la intersección
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM Semaforo WHERE IdInterseccion = ?");
        $stmt->bind_param('i', $idInterseccion);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['total'] >= 4) {
            return false; // No permitir más de 4 semáforos
        }

        // Insertar el nuevo semáforo si aún hay espacio
        $stmt = $this->conn->prepare(
            "INSERT INTO Semaforo (IdInterseccion, TiempoVerde, TiempoAmarillo, TiempoRojo, EstadoActual, Activo) 
         VALUES (?, ?, ?, ?, ?, 1)"
        );
        $stmt->bind_param('iiiss', $idInterseccion, $tiempoVerde, $tiempoAmarillo, $tiempoRojo, $estadoActual);
        return $stmt->execute();
    }


    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Semaforo WHERE Id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $idInterseccion, $tiempoVerde, $tiempoAmarillo, $tiempoRojo, $estadoActual)
    {
        $stmt = $this->conn->prepare(
            "UPDATE Semaforo SET IdInterseccion = ?, TiempoVerde = ?, TiempoAmarillo = ?, 
             TiempoRojo = ?, EstadoActual = ? WHERE Id = ?"
        );
        $stmt->bind_param('iiissi', $idInterseccion, $tiempoVerde, $tiempoAmarillo, $tiempoRojo, $estadoActual, $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("UPDATE Semaforo SET Activo = 0 WHERE Id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function getIntersecciones()
    {
        $result = $this->conn->query("SELECT Id, Descripcion FROM Interseccion");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
