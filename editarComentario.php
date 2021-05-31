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

    $comentario = $application->obtenerComentario($idEvento, $idComentario)[0];
    $palabrotas = $application->obtenerPalabrotas();

    echo $twig->render('editar-comentario.html', ['usuario' => $_SESSION, 'comentario' => $comentario, 'palabrotas' => $palabrotas]);
}

$application->cerrarConexion();
?>