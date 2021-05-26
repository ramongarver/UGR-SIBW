<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once "./scripts/db.php";

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  function startsWith($string, $query) {
      return substr($string, 0, strlen($query)) === $query;
  }

  session_start();
  $sesion = $_SESSION;

  $uri = $_SERVER['REQUEST_URI'];

  if (startsWith($uri, "/evento")) {
    include("scripts/evento.php");
  }
  elseif (startsWith($uri, "/login") and !isset($_SESSION['username'])) {
    echo $twig->render('login.html', []);
  }
  elseif (startsWith($uri, "/register") and !isset($_SESSION['username'])) {
    echo $twig->render('register.html', []);
  }
  elseif (startsWith($uri, "/perfil") and isset($_SESSION['username'])) {
    $application = new AppDB();
    $usuario = $application->obtenerUsuario($_SESSION['username'])[0];

    if (startsWith($uri, "/perfil/editar")) {
      echo $twig->render('perfil_editar.html', ['usuario' => $usuario, 'sesion' => $sesion]);
    }
    else {
      echo $twig->render('perfil.html', ['usuario' => $usuario, 'sesion' => $sesion]);
    }

    $application->cerrarConexion();
  }
  else {
    $application = new AppDB();
    $eventos = $application->obtenerEventos();

    echo $twig->render('portada.html', ['eventos' => $eventos, 'sesion' => $sesion]);

    $application->cerrarConexion();
  }
?>
