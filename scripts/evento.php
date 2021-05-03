<?php
  require_once "./scripts/db.php";

  $resto = substr($uri, 8);

  $idEvento = intval($resto);

  $resto = substr($resto, strlen((string)$idEvento));

  $application = new AppDB();
  $evento = $application->obtenerEvento($idEvento); //$evento['descripcion'] = nl2br($evento['descripcion']);
  $imagenes = $application->obtenerImagenes($idEvento);
  $comentarios = $application->obtenerComentarios($idEvento);
  $palabrotas = $application->obtenerPalabrotas();

  if ($resto === "/imprimir" || $resto === "/imprimir/") {
    echo $twig->render('evento-imprimir.html', ['evento' => $evento, 'imagenes' => $imagenes]);
  }
  else {
    echo $twig->render('evento.html', ['evento' => $evento, 'imagenes' => $imagenes, 'comentarios' => $comentarios, 'palabrotas' => $palabrotas]);
  }

  $application->cerrarConexion();
?>
