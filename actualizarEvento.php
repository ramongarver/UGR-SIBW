<?php
require_once "/usr/local/lib/php/vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once './scripts/db.php';

session_start();

$application = new AppDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si no se cambia la portada
    if($_FILES['portada']['error'] === UPLOAD_ERR_NO_FILE) {
        $url_portada = null;
    }
    else { // Si hay nueva portada
        $portada_tmp = $_FILES['portada']['tmp_name'];
        $portada_name = $_FILES['portada']['name'];
        $url_portada = "/img/$portada_name";
        move_uploaded_file($portada_tmp, "." . $url_portada);
    }

    // Si no se cambian las imágenes
    if($_FILES['imagenes']['error'][0] === UPLOAD_ERR_NO_FILE) {
        $url_imagenes = null;
    }
    else { // Si hay nuevas imágenes
        $imagenes_tmp = $_FILES['imagenes']['tmp_name'];
        $imagenes_name = $_FILES['imagenes']['name'];
        for ($i = 0; $i < sizeof($imagenes_name); $i++) {
            $url_imagenes[$i] = "/img/$imagenes_name[$i]";
        }
        for ($i = 0; $i < sizeof($imagenes_name); $i++) {
            move_uploaded_file($imagenes_tmp[$i], "." . $url_imagenes[$i]);
        }
    }

    $idEvento = $_POST['idEvento'];
    $nombre = $_POST['nombre'];
    $organizador = $_POST['organizador'];
    $lugar = $_POST['lugar'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $url = $_POST['url'];
    $descripcion = $_POST['descripcion'];

    if($application->actualizarEvento($idEvento, $nombre, $organizador, $lugar, $fecha, $hora, $url, $descripcion, $url_portada, $url_imagenes)) {
        header("Location: /evento/$idEvento");
    }
}

$application->cerrarConexion();
?>