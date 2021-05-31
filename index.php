<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once "./scripts/db.php";

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  function startsWith($string, $query) {
      return substr($string, 0, strlen($query)) === $query;
  }

  session_start();

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
    if (startsWith($uri, "/perfil/editar")) {
      if ($_SESSION['rol'] === "Superusuario" and startsWith($uri, "/perfil/editar-roles")) {
        $application = new AppDB();
        $usuarios = $application->obtenerUsuariosRol();
        $roles = [['rol' => "Registrado", "id_rol" => 1], ['rol' => "Moderador", "id_rol" => 2], ['rol' => "Gestor", "id_rol" => 3], ['rol' => "Moderador y Gestor", "id_rol" => 4], ['rol' => "Superusuario", "id_rol" => 5]];

        echo $twig->render('editar-roles.html', ['usuario' => $_SESSION, 'usuarios' => $usuarios, 'roles' => $roles]);

        $application->cerrarConexion();
      }
      else {
        echo $twig->render('editar-perfil.html', ['usuario' => $_SESSION]);
      }
    }
    else {
      echo $twig->render('perfil.html', ['usuario' => $_SESSION]);
    }
  }
  elseif (startsWith($uri, "/listado-comentarios") and isset($_SESSION['username']) and $_SESSION['rol'] != 'Registrado' and $_SESSION['rol'] != 'Gestor') {
    $application = new AppDB();
    $eventosComentarios = $application->obtenerListaComentarios();

    echo $twig->render('listado-comentarios.html', ['usuario' => $_SESSION, 'eventos' => $eventosComentarios]);

    $application->cerrarConexion();
  }
  elseif (startsWith($uri, "/listado-eventos") and isset($_SESSION['username']) and $_SESSION['rol'] != 'Registrado' and $_SESSION['rol'] != 'Moderador') {
    $application = new AppDB();
    $eventos = $application->obtenerNombreEventos();

    echo $twig->render('listado-eventos.html', ['usuario' => $_SESSION, 'eventos' => $eventos]);

    $application->cerrarConexion();
  }
  elseif (startsWith($uri, "/crear-evento") and isset($_SESSION['username']) and $_SESSION['rol'] != 'Registrado' and $_SESSION['rol'] != 'Moderador') {
    echo $twig->render('crear-evento.html', ['usuario' => $_SESSION]);
  }
  else {
    $application = new AppDB();
    $eventos = $application->obtenerEventos();

    echo $twig->render('portada.html', ['usuario' => $_SESSION, 'eventos' => $eventos]);

    $application->cerrarConexion();
  }
?>
