<?php
  require_once "./scripts/db.php";

  $resto = substr($uri, 8);

  $idEvento = intval($resto);

  $resto = substr($resto, strlen((string)$idEvento));

  $application = new AppDB();
  $evento = $application->obtenerEvento($idEvento); //$evento['descripcion'] = nl2br($evento['descripcion']);

  // Si un evento tiene asociadas más de dos imágenes se muestran dos de forma aleatoria
  $imagenesTodas = $application->obtenerImagenes($idEvento);
  if (sizeof($imagenesTodas) > 2) {
    $id[0] = rand(0, sizeof($imagenesTodas)-1);
    do {
      $id[1] = rand(0, sizeof($imagenesTodas)-1);
    } while ($id[0] === $id[1]);

    for ($i = 0; $i < 2; $i++) {
      $imagenes[$i] = $imagenesTodas[$id[$i]];
    }
  }
  else {
    $imagenes = $imagenesTodas;
  }

  $comentarios = $application->obtenerComentarios($idEvento);
  $etiquetas = $application->obtenerEtiquetas($idEvento);
  $palabrotas = $application->obtenerPalabrotas();

  if ($resto === "/imprimir" || $resto === "/imprimir/") {
    echo $twig->render('evento-imprimir.html', ['evento' => $evento, 'imagenes' => $imagenes]);
  }
  elseif ($resto === "/editar" || $resto === "/editar/" and isset($_SESSION['username']) and $_SESSION['rol'] != 'Registrado' and $_SESSION['rol'] != 'Moderador') {
    echo $twig->render('editar-evento.html', ['usuario' => $_SESSION, 'evento' => $evento, 'imagenes' => $imagenes]);
  }
  elseif ($resto === "/crear-etiqueta" || $resto === "/crear-etiquete/" and isset($_SESSION['username']) and $_SESSION['rol'] != 'Registrado' and $_SESSION['rol'] != 'Moderador') {
    echo $twig->render('crear-etiqueta.html', ['usuario' => $_SESSION, 'evento' => $evento]);
  }
  else {
    echo $twig->render('evento.html', ['usuario' => $_SESSION, 'evento' => $evento, 'imagenes' => $imagenes, 'comentarios' => $comentarios, 'palabrotas' => $palabrotas, 'etiquetas' => $etiquetas]);
  }

  $application->cerrarConexion();
?>
