<?php
require_once "/usr/local/lib/php/vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once './scripts/db.php';

session_start();

$application = new AppDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEvento = $_POST['idEvento'];
    $idComentario = $_POST['idComentario'];
    $idModerador = $_SESSION['id_usuario'];
    $comentario = $_POST['texto-comentario'];

    if($application->actualizarComentario($idEvento, $idComentario, $idModerador, $comentario)) {
        header("Location: /evento/$idEvento");
    }
}

$application->cerrarConexion();
?>