<?php
require_once "/usr/local/lib/php/vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once './scripts/db.php';

session_start();

$application = new AppDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST;

    if (!$application->existeUsuario($usuario['username']) or $_SESSION['username'] === $usuario['username']) {
        $usuario['previousUsername'] = $_SESSION['username'];
        if($application->actualizarUsuario($usuario)) {
            $_SESSION = $application->obtenerUsuario($usuario['username'])[0];
            header("Location:/perfil");
        }
        else {
            header("Location:/perfil/editar");
        }
    }
    else {
        header("Location:/perfil/editar");
    }
}

echo $twig->render('editar-perfil.html', []);

$application->cerrarConexion();
?>