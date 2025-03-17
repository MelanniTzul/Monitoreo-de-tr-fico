<?php

namespace models;
require_once __DIR__ . '/../config/config.php';

class Avenida
{
    private $conn;

    public function __construct()
    {
        global $mysqli;
        $this->conn = $mysqli;
    }

    public function getAll()
    {
        $query = "SELECT a.Id, a.Nombre, a.NumeroCarriles, s.Tipo AS Sentido, a.Activo 
                  FROM Avenida a
                  LEFT JOIN Sentido s ON a.IdSentido = s.Id
                  WHERE a.Activo = 1";
        $result = $this->conn->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function create($nombre, $numeroCarriles, $idSentido)
    {
        $stmt = $this->conn->prepare("INSERT INTO Avenida (Nombre, NumeroCarriles, IdSentido, Activo) VALUES (?, ?, ?, 1)");
        $stmt->bind_param('sii', $nombre, $numeroCarriles, $idSentido);
        return $stmt->execute();
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Avenida WHERE Id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $nombre, $numeroCarriles, $idSentido)
    {
        $stmt = $this->conn->prepare("UPDATE Avenida SET Nombre = ?, NumeroCarriles = ?, IdSentido = ? WHERE Id = ?");
        $stmt->bind_param('siii', $nombre, $numeroCarriles, $idSentido, $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("UPDATE Avenida SET Activo = 0 WHERE Id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function getSentidos()
    {
        $result = $this->conn->query("SELECT Id, Tipo FROM Sentido");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
