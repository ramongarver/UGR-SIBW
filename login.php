<?php
require_once "/usr/local/lib/php/vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once './scripts/db.php';

$application = new AppDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($application->comprobarLogin($username, $password)) {
        session_start();

        $_SESSION['username'] = $username;  // Guardo en la sesión el username del usuario que se ha logueado
        header("Location: /");
    }
    else {
        header("Location: /login");
    }
}

echo $twig->render('login.html', []);
?>