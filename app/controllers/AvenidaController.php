<?php

use models\Avenida;

require_once __DIR__ . '/../models/Avenida.php';

class AvenidaController
{
    public function index()
    {
        $avenidaModel = new Avenida();
        $avenidas = $avenidaModel->getAll();

        require_once __DIR__ . '/../views/avenida/index.php';
    }

    public function crear()
    {
        $avenidaModel = new Avenida();
        $sentidos = $avenidaModel->getSentidos();

        require_once __DIR__ . '/../views/avenida/crear.php';
    }

    public function store()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = $_POST['nombre'];
            $numeroCarriles = $_POST['numeroCarriles'];
            $idSentido = $_POST['idSentido'];

            $avenidaModel = new Avenida();
            $avenidaModel->create($nombre, $numeroCarriles, $idSentido);

            header("Location: index.php?controller=Avenida&action=index&success=1");
            exit();
        }
    }

    public function edit()
    {
        $id = $_GET['id'];
        $avenidaModel = new Avenida();
        $avenida = $avenidaModel->getById($id);
        $sentidos = $avenidaModel->getSentidos();

        require_once __DIR__ . '/../views/avenida/editar.php';
    }

    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $numeroCarriles = $_POST['numeroCarriles'];
            $idSentido = $_POST['idSentido'];

            $avenidaModel = new Avenida();
            $avenidaModel->update($id, $nombre, $numeroCarriles, $idSentido);

            header("Location: index.php?controller=Avenida&action=index&success=1");
            exit();
        }
    }

    public function delete()
    {
        $id = $_GET['id'];
        $avenidaModel = new Avenida();
        $avenidaModel->delete($id);

        header("Location: index.php?controller=Avenida&action=index&success=1");
    }
}
