<?php
require_once "/usr/local/lib/php/vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once './scripts/db.php';

session_start();

$application = new AppDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = json_decode($_POST['rol'], true);
    $username = $json['username'];
    $idRol = $json['id_rol'];

    if ($application->editarRolUsuario($username, $idRol)) {
        header("Location: /perfil/editar-roles");
    }
}

$application->cerrarConexion();
?>