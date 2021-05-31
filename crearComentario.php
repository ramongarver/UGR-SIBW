<?php
require_once "/usr/local/lib/php/vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once './scripts/db.php';

session_start();

$application = new AppDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEvento = $_POST['idEvento'];
    $idUsuario = $_POST['idUsuario'];
    $fecha = date('Y-m-d H:i:s', strtotime("+2 hours"));
    $comentario = $_POST['texto-comentario'];

    $idComentario = $application->conexion->prepare("SELECT max(id_comentario) FROM comentarios WHERE id_evento = ?");
    $idComentario->bind_param("i", $idEvento);
    $idComentario->execute();
    $idComentario = $idComentario->get_result();
    $idComentario = $idComentario->fetch_all(MYSQLI_ASSOC)[0]['max(id_comentario)'];
    if ($idComentario == null) { $idComentario = 1; }
    else { $idComentario = intval($idComentario) + 1; }

    if($application->crearComentario($idEvento, $idComentario, $idUsuario, $fecha, $comentario)) {
        header("Location: /evento/$idEvento");
    }
}

$application->cerrarConexion();
?>