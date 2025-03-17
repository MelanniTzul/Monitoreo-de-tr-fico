<?php

namespace models;
require_once __DIR__ . '/../config/config.php';

class Interseccion
{
    private $conn;

    public function __construct()
    {
        global $mysqli;
        $this->conn = $mysqli;
    }

    public function getAll()
    {
        $query = "SELECT i.Id, c.Nombre as Calle, a.Nombre as Avenida, i.Descripcion 
                  FROM Interseccion i
                  JOIN Calle c ON i.IdCalle = c.Id
                  JOIN Avenida a ON i.IdAvenida = a.Id";
        $result = $this->conn->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function create($idCalle, $idAvenida, $descripcion)
    {
        $stmt = $this->conn->prepare("INSERT INTO Interseccion (IdCalle, IdAvenida, Descripcion) VALUES (?, ?, ?)");
        $stmt->bind_param('iis', $idCalle, $idAvenida, $descripcion);
        return $stmt->execute();
    }

    public function getCalles()
    {
        $result = $this->conn->query("SELECT Id, Nombre FROM Calle");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getAvenidas()
    {
        $result = $this->conn->query("SELECT Id, Nombre FROM Avenida");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
