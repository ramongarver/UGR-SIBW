<?php
require_once "/usr/local/lib/php/vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once './scripts/db.php';

session_start();

$application = new AppDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($application->comprobarLogin($username, $password)) {
        session_start();
        $_SESSION = $application->obtenerUsuario($username)[0];

        header("Location: /");
    }
    else {
        header("Location: /login");
    }
}

echo $twig->render('login.html', []);

$application->cerrarConexion();
?>