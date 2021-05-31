<?php
require_once "/usr/local/lib/php/vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once './scripts/db.php';

session_start();

$application = new AppDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_FILES['portada']['error'] === UPLOAD_ERR_OK) {
        $portada_tmp = $_FILES['portada']['tmp_name'];
        $portada_name = $_FILES['portada']['name'];
        $url_portada = "/img/$portada_name";
        move_uploaded_file($portada_tmp, "." . $url_portada);
    }

    if ($_FILES['imagenes']['error'][0] === UPLOAD_ERR_OK) {
        $imagenes_tmp = $_FILES['imagenes']['tmp_name'];
        $imagenes_name = $_FILES['imagenes']['name'];
        for ($i = 0; $i < sizeof($imagenes_name); $i++) {
            $url_imagenes[$i] = "/img/$imagenes_name[$i]";
        }
        for ($i = 0; $i < sizeof($imagenes_name); $i++) {
            move_uploaded_file($imagenes_tmp[$i], "." . $url_imagenes[$i]);
        }
    }

    $nombre = $_POST['nombre'];
    $organizador = $_POST['organizador'];
    $lugar = $_POST['lugar'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $url = $_POST['url'];
    $descripcion = $_POST['descripcion'];
    $publicado = $_POST['publicado'];
    if ($publicado === 'on') { $publicado = 1; }
    else $publicado = 0;

    $idEvento = $application->conexion->query("SELECT max(id_evento) FROM eventos");
    $idEvento = $idEvento->fetch_all(MYSQLI_ASSOC)[0]['max(id_evento)'];
    if ($idEvento == null) { $idEvento = 1; }
    else { $idEvento = intval($idEvento) + 1; }

    if($application->crearEvento($idEvento, $nombre, $organizador, $lugar, $fecha, $hora, $url, $descripcion, $url_portada, $url_imagenes, $publicado)) {
        header("Location: /evento/$idEvento");
    }
}

$application->cerrarConexion();
?>