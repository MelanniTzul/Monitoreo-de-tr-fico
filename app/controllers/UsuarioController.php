<?php

use models\Usuario;

require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController
{
    public function index()
    {
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->getAll();
        require_once __DIR__ . '/../views/usuario/index.php';
    }

    public function createForm(){
        $usuarioModel = new Usuario();
        $roles = $usuarioModel->getRoles();
        require_once __DIR__ . '/../views/usuario/crear.php';
    }

    public function create()
    {
        $nombre   = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $idRol    = $_POST['idRol'];

        $usuarioModel = new Usuario();
        $usuarioModel->create($nombre, $apellido, $username, $password, $idRol);

        header('Location: index.php?controller=Usuario&action=index');
    }

    public function edit()
    {
        $id = $_GET['id'];
        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->getById($id);
        $roles = $usuarioModel->getRoles();

        require_once __DIR__ . '/../views/usuario/edit.php';
    }

    public function update()
    {
        $id       = $_POST['id'];
        $nombre   = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $idRol    = $_POST['idRol'];

        $usuarioModel = new Usuario();
        $usuarioModel->update($id, $nombre, $apellido, $username, $password, $idRol);

        header('Location: index.php?controller=Usuario&action=index');
    }

    public function delete()
    {
        $id = $_GET['id'];

        $usuarioModel = new Usuario();
        $usuarioModel->delete($id);

        header('Location: index.php?controller=Usuario&action=index');
    }
}
