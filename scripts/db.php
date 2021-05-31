<?php
    require_once "utilidades.php";

    class AppDB {
        private $host = "mysql";
        private $usuario = "admin";
        private $clave = "admin";
        private $db = "events";
        public $conexion = null;

        public function __construct(){
            $this->conexion = new mysqli($this->host, $this->usuario, $this->clave, $this->db) or die(mysqli_error());
        }

        public function obtenerEventos() {
            $infoEventos = $this->conexion->query("SELECT id_evento, nombre, fecha, url_portada FROM eventos");
            return $infoEventos->fetch_all(MYSQLI_ASSOC);
        }

        public function obtenerEventosPublicados() {
            $infoEventos = $this->conexion->query("SELECT id_evento, nombre, fecha, url_portada FROM eventos WHERE publicado = 1");
            return $infoEventos->fetch_all(MYSQLI_ASSOC);
        }

        public function obtenerEventosBusquedaParcial($busqueda) {
            $busqueda = "%".$busqueda."%";
            $infoEventos = $this->conexion->prepare("SELECT id_evento, nombre, fecha, url_portada FROM eventos WHERE nombre LIKE ?");
            $infoEventos->bind_param("s", $busqueda);
            if(!$infoEventos->execute()) {
                return false;
            }
            $infoEventos = $infoEventos->get_result();
            return $infoEventos->fetch_all(MYSQLI_ASSOC);
        }

        public function obtenerEventosBusquedaParcialPublicados($busqueda) {
            $busqueda = "%".$busqueda."%";
            $infoEventos = $this->conexion->prepare("SELECT id_evento, nombre, fecha, url_portada FROM eventos WHERE publicado = 1 AND nombre LIKE ?");
            $infoEventos->bind_param("s", $busqueda);
            if(!$infoEventos->execute()) {
                return false;
            }
            $infoEventos = $infoEventos->get_result();
            return $infoEventos->fetch_all(MYSQLI_ASSOC);
        }

        public function obtenerEvento($idEvento) {
            $infoEvento = $this->conexion->prepare("SELECT id_evento, nombre, organizador, fecha, hora, lugar, url, descripcion, publicado FROM eventos WHERE id_evento = ?");
            $infoEvento->bind_param("i", $idEvento);
            $infoEvento->execute();
            $infoEvento = $infoEvento->get_result();
            $evento = $infoEvento->fetch_assoc();
            if ($infoEvento->num_rows <= 0) {
                $evento['id_evento'] = 0;
                $evento['nombre'] = "Nombre del Evento";
                $evento['organizador'] = "Organizador del Evento";
                $evento['fecha'] = "YYYY-MM-DD";
                $evento['hora'] = "HH:MM:SS";
                $evento['lugar'] = "lugar del Evento";
                $evento['url'] = "https://www.webdelorganizador.com";
                $evento['descripcion'] = "Descripción del evento";
            }
            return $evento;
        }

        public function obtenerNombreEventos() {
            $infoEventos = $this->conexion->query("SELECT id_evento, nombre FROM eventos");
            return $infoEventos->fetch_all(MYSQLI_ASSOC);
        }

        public function obtenerUrlPortada($idEvento) {
            $infoUrlPortada = $this->conexion->prepare("SELECT url_portada FROM eventos WHERE id_evento = ?");
            $infoUrlPortada->bind_param("i", $idEvento);
            $infoUrlPortada->execute();
            $infoUrlPortada = $infoUrlPortada->get_result();
            $infoUrlPortada = $infoUrlPortada->fetch_assoc();
            return $infoUrlPortada['url_portada'];
        }

        public function crearEvento($idEvento, $nombre, $organizador, $lugar, $fecha, $hora, $url, $descripcion, $url_portada, $url_imagenes, $publicado) {
            $creacionEvento = $this->conexion->prepare("INSERT INTO eventos(id_evento, nombre, organizador, lugar, fecha, hora, url, descripcion, url_portada, publicado) 
                     VALUES
                     (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $creacionEvento->bind_param("issssssssi", $idEvento, $nombre, $organizador, $lugar, $fecha, $hora, $url, $descripcion, $url_portada, $publicado);
            if(!$creacionEvento->execute()) {
                return false;
            }
            if (!$this->crearImagenes($idEvento, $url_imagenes)) {
                return false;
            }
            return true;
        }

        public function actualizarEvento($idEvento, $nombre, $organizador, $lugar, $fecha, $hora, $url, $descripcion, $url_portada, $url_imagenes, $publicado) {
            if($url_imagenes !== null) {
                $this->eliminarImagenesEventoNoCoincidentes($idEvento, $this->obtenerUrlImagenes($idEvento));
                if(!$this->crearImagenes($idEvento, $url_imagenes)) {
                    return false;
                }
            }

            if($url_portada === null) {
                $url_portada = $this->obtenerUrlPortada($idEvento);
            }
            else {
                $url_portada_vieja = $this->obtenerUrlPortada($idEvento);
                if ($url_portada_vieja !== null and $url_portada !== $url_portada_vieja and !in_array($url_portada_vieja, $this->obtenerUrlImagenes($idEvento))) {
                    unlink("." . $url_portada_vieja);
                }
            }

            $actualizacionEvento = $this->conexion->prepare("UPDATE eventos SET nombre = ?, organizador = ?, lugar = ?, fecha = ?, hora = ?, url = ?, descripcion = ?, url_portada = ?, publicado = ? WHERE id_evento = ?");
            $actualizacionEvento->bind_param("ssssssssii", $nombre, $organizador, $lugar, $fecha, $hora, $url, $descripcion, $url_portada, $publicado, $idEvento);
            if(!$actualizacionEvento->execute()) {
                return false;
            }
            return true;
        }

        public function obtenerImagenes($idEvento) {
            $infoImagenes = $this->conexion->prepare("SELECT id_imagen, autor, year, descripcion, path FROM imagenes WHERE id_evento = ?");
            $infoImagenes->bind_param("i", $idEvento);
            $infoImagenes->execute();
            $infoImagenes = $infoImagenes->get_result();
            return $infoImagenes->fetch_all(MYSQLI_ASSOC);
        }

        public function obtenerListaComentarios() {
            $infoEventosComentarios = $this->obtenerNombreEventos();

            for ($i = 0; $i < sizeof($infoEventosComentarios); $i++) {
                $infoEventosComentarios[$i]['comentarios'] = $this->obtenerComentarios($infoEventosComentarios[$i]['id_evento']);
            }

            return $infoEventosComentarios;
        }

        public function obtenerComentarios($idEvento) {
            $infoComentarios = $this->conexion->prepare("SELECT id_comentario, id_moderador, nombre, fecha, comentario FROM comentarios NATURAL JOIN usuarios WHERE id_evento = ? ORDER BY fecha");
            $infoComentarios->bind_param("i", $idEvento);
            $infoComentarios->execute();
            $infoComentarios = $infoComentarios->get_result();
            return $infoComentarios->fetch_all(MYSQLI_ASSOC);
        }

        public function obtenerComentario($idEvento, $idComentario) {
            $infoComentario = $this->conexion->prepare("SELECT id_evento, id_comentario, id_moderador, nombre, fecha, email, comentario FROM comentarios NATURAL JOIN usuarios WHERE id_evento = ? AND id_comentario = ?");
            $infoComentario->bind_param("ii", $idEvento, $idComentario);
            $infoComentario->execute();
            $infoComentarios = $infoComentario->get_result();
            return $infoComentarios->fetch_all(MYSQLI_ASSOC);
        }

        public function obtenerPalabrotas() {
            $infoPalabrotas = $this->conexion->query("SELECT palabrota FROM palabrotas");
            return $infoPalabrotas->fetch_all(MYSQLI_ASSOC);
        }

        public function crearComentario($idEvento, $idComentario, $idUsuario, $fecha, $comentario) {
            $creacionComentario = $this->conexion->prepare("INSERT INTO comentarios(id_evento, id_comentario, id_usuario, fecha, comentario) 
                     VALUES
                     (?, ?, ?, ?, ?)");
            $creacionComentario->bind_param("iiiss", $idEvento, $idComentario, $idUsuario, $fecha, $comentario);
            return $creacionComentario->execute();
        }

        public function eliminarComentario($idEvento, $idComentario) {
            $eliminarComentario = $this->conexion->prepare("DELETE FROM comentarios WHERE id_evento = ? AND id_comentario = ?");
            $eliminarComentario->bind_param("ii", $idEvento, $idComentario);
            return $eliminarComentario->execute();
        }

        public function eliminarComentarios($idEvento) {
            $eliminarComentarios = $this->conexion->prepare("DELETE FROM comentarios WHERE id_evento = ?");
            $eliminarComentarios->bind_param("i", $idEvento);
            return $eliminarComentarios->execute();
        }

        public function actualizarComentario($idEvento, $idComentario, $idModerador, $comentario) {
            $actualizacionComentario = $this->conexion->prepare("UPDATE comentarios SET comentario = ?, id_moderador = ? WHERE id_evento = ? AND id_comentario = ?");
            $actualizacionComentario->bind_param("siii", $comentario, $idModerador, $idEvento, $idComentario);
            return $actualizacionComentario->execute();
        }

        public function crearImagen($idEvento, $url_imagen) {
            $idImagen = $this->conexion->query("SELECT max(id_imagen) FROM imagenes");
            $idImagen = $idImagen->fetch_all(MYSQLI_ASSOC)[0]['max(id_imagen)'];
            if ($idImagen == null) { $idImagen = 1; }
            else { $idImagen = intval($idImagen) + 1; }

            $creacionImagen = $this->conexion->prepare("INSERT INTO imagenes(id_imagen, id_evento, autor, year, descripcion, path) 
                     VALUES
                     (?, ?, 'Autor Desconocido', '1969', 'Descripción', ?)");
            $creacionImagen->bind_param("iis", $idImagen, $idEvento, $url_imagen);
            return $creacionImagen->execute();
        }

        public function crearImagenes($idEvento, $url_imagenes) {
            if ($url_imagenes !== null) {
                for ($i = 0; $i < sizeof($url_imagenes); $i++) {
                    if(!$this->crearImagen($idEvento, $url_imagenes[$i])) {
                        return false;
                    }
                }
            }
            return true;
        }

        public function eliminarPortadaEvento($idEvento) {
            $rutaPortada = $this->conexion->prepare("SELECT url_portada FROM eventos WHERE id_evento = ?");
            $rutaPortada->bind_param("i", $idEvento);
            if(!$rutaPortada->execute()) {
                return false;
            }

            $rutaPortada = $rutaPortada->get_result();
            $rutaPortada = $rutaPortada->fetch_all(MYSQLI_ASSOC);
            $rutaPortada = $rutaPortada[0]['url_portada'];
            if ($rutaPortada !== null) {
                if (file_exists("." . $rutaPortada)) {
                    unlink("." . $rutaPortada);
                }
            }

            return true;
        }

        public function eliminarImagenesEvento($idEvento) {
            $rutasImagenes = $this->conexion->prepare("SELECT path FROM imagenes WHERE id_evento = ?");
            $rutasImagenes->bind_param("i", $idEvento);
            if(!$rutasImagenes->execute()) {
                return false;
            }
            $rutasImagenes = $rutasImagenes->get_result();
            $rutasImagenes = $rutasImagenes->fetch_all(MYSQLI_ASSOC);
            for ($i = 0; $i < sizeof($rutasImagenes); $i++) {
                unlink("." . $rutasImagenes[$i]['path']);
            }

            $eliminarImagenes = $this->conexion->prepare("DELETE FROM imagenes WHERE id_evento = ?");
            $eliminarImagenes->bind_param("i", $idEvento);
            if(!$eliminarImagenes->execute()) {
                return false;
            }

            return true;
        }

        public function eliminarImagenesEventoNoCoincidentes($idEvento, $url_imagenes) {
            $rutasImagenes = $this->conexion->prepare("SELECT path FROM imagenes WHERE id_evento = ?");
            $rutasImagenes->bind_param("i", $idEvento);
            if(!$rutasImagenes->execute()) {
                return false;
            }
            $rutasImagenes = $rutasImagenes->get_result();
            $rutasImagenes = $rutasImagenes->fetch_all(MYSQLI_ASSOC);
            for ($i = 0; $i < sizeof($rutasImagenes); $i++) {
                if (!in_array($rutasImagenes[$i]['path'], $url_imagenes)) {
                    unlink("." . $rutasImagenes[$i]['path']);
                }
            }

            $eliminarImagenes = $this->conexion->prepare("DELETE FROM imagenes WHERE id_evento = ?");
            $eliminarImagenes->bind_param("i", $idEvento);
            if(!$eliminarImagenes->execute()) {
                return false;
            }

            return true;
        }

        public function obtenerUrlImagenes($idEvento) {
            $rutasImagenes = $this->conexion->prepare("SELECT path FROM imagenes WHERE id_evento = ?");
            $rutasImagenes->bind_param("i", $idEvento);
            if(!$rutasImagenes->execute()) {
                return false;
            }
            $rutasImagenes = $rutasImagenes->get_result();
            $rutasImagenes = $rutasImagenes->fetch_all(MYSQLI_ASSOC);
            for ($i = 0; $i < sizeof($rutasImagenes); $i++) {
                $rutasImagenes[$i] = $rutasImagenes[$i]['path'];
            }

            return $rutasImagenes;
        }

        public function eliminarImagenes($idEvento) {
            if(!$this->eliminarImagenesEvento($idEvento)) {
                return false;
            }
            if(!$this->eliminarPortadaEvento($idEvento)) {
                return false;
            }
            return true;
        }

        public function obtenerEtiquetas($idEvento) {
            $infoEtiquetas = $this->conexion->prepare("SELECT id_etiqueta, id_evento, etiqueta FROM etiquetas WHERE id_evento = ?");
            $infoEtiquetas->bind_param("i", $idEvento);
            $infoEtiquetas->execute();
            $infoEtiquetas = $infoEtiquetas->get_result();
            return $infoEtiquetas->fetch_all(MYSQLI_ASSOC);
        }

        public function crearEtiqueta($idEvento, $idEtiqueta, $etiqueta) {
            $creacionEtiqueta = $this->conexion->prepare("INSERT INTO etiquetas(id_evento, id_etiqueta, etiqueta) 
                     VALUES
                     (?, ?, ?)");
            $creacionEtiqueta->bind_param("iis", $idEvento, $idEtiqueta, $etiqueta);
            return $creacionEtiqueta->execute();
        }

        public function eliminarEtiqueta($idEvento, $idEtiqueta) {
            $eliminarEtiqueta = $this->conexion->prepare("DELETE FROM etiquetas WHERE id_evento = ? AND id_etiqueta = ?");
            $eliminarEtiqueta->bind_param("ii", $idEvento, $idEtiqueta);
            return $eliminarEtiqueta->execute();
        }

        public function eliminarEtiquetas($idEvento) {
            $eliminarEtiquetas = $this->conexion->prepare("DELETE FROM etiquetas WHERE id_evento = ?");
            $eliminarEtiquetas->bind_param("i", $idEvento);
            return $eliminarEtiquetas->execute();
        }

        public function eliminarEvento($idEvento) {
            $this->eliminarComentarios($idEvento);
            $this->eliminarImagenes($idEvento);
            $this->eliminarEtiquetas($idEvento);
            $eliminarEvento = $this->conexion->prepare("DELETE FROM eventos WHERE id_evento = ?");
            $eliminarEvento->bind_param("i", $idEvento);
            return $eliminarEvento->execute();
        }

        public function comprobarLogin($username, $password) {
            $usuarios = $this->obtenerUsuarios();

            for ($i = 0; $i < sizeof($usuarios); $i++) {
                if ($usuarios[$i]['username'] === $username) {
                    return password_verify($password, $usuarios[$i]['password']);
                }
            }

            return false;
        }

        public function obtenerUsuarios() {
            $infoUsuarios = $this->conexion->query("SELECT * FROM usuarios");
            return $infoUsuarios->fetch_all(MYSQLI_ASSOC);
        }

        public function obtenerUsuario($username) {
            $infoUsuario = $this->conexion->prepare("SELECT * FROM usuarios WHERE username = ?");
            $infoUsuario->bind_param("s", $username);
            $infoUsuario->execute();
            $infoUsuario = $infoUsuario->get_result();
            $infoUsuario = $infoUsuario->fetch_all(MYSQLI_ASSOC);
            $infoUsuario[0]['rol'] = id_roltoRol($infoUsuario[0]['id_rol']);
            $infoUsuario[0]['genero'] = charGenerotoStringGenero($infoUsuario[0]['genero']);
            return $infoUsuario;
        }

        public function obtenerUsuariosRol() {
            $infoUsuario = $this->conexion->query("SELECT username, id_rol FROM usuarios");
            $infoUsuario = $infoUsuario->fetch_all(MYSQLI_ASSOC);
            for ($i = 0; $i < sizeof($infoUsuario); $i++) {
                $infoUsuario[$i]['rol'] = id_roltoRol($infoUsuario[$i]['id_rol']);
            }
            return $infoUsuario;
        }

        public function existeUsuario($username) {
            $infoUsuario = $this->conexion->prepare("SELECT username FROM usuarios WHERE username = ?");
            $infoUsuario->bind_param("s", $username);
            $infoUsuario->execute();
            return $infoUsuario->get_result()->num_rows == 1;
        }

        public function registrarUsuario($usuario) {
            $hash = password_hash($usuario['password'], PASSWORD_DEFAULT);
            $fecha_registro = date('Y-m-d', strtotime("+2 hours"));

            $registroUsuario = $this->conexion->prepare("INSERT INTO usuarios(username, password, id_rol, nombre, apellidos, 
                     email, genero, fecha_nacimiento, telefono, fecha_registro) 
                     VALUES
                     (?, ?, '1', ?, ?, ?, ?, ?, ?, ?)");
            $registroUsuario->bind_param("sssssssss", $usuario['username'], $hash, $usuario['nombre'], $usuario['apellidos'], $usuario['email'], $usuario['genero'], $usuario['fecha_nacimiento'], $usuario['telefono'], $fecha_registro);
            return $registroUsuario->execute();
        }

        public function actualizarUsuario($usuario) {
            $actualizacionUsuario = $this->conexion->prepare("UPDATE usuarios SET username = ?, email = ?, nombre = ?, apellidos = ?, telefono = ?, genero = ? WHERE username = ?");
            $actualizacionUsuario->bind_param("sssssss", $usuario['username'], $usuario['email'], $usuario['nombre'], $usuario['apellidos'], $usuario['telefono'], $usuario['genero'], $usuario['previousUsername']);
            return $actualizacionUsuario->execute();
        }

        public function editarRolUsuario($username, $idRol) {
            $edicionRolUsuario = $this->conexion->prepare("UPDATE usuarios SET id_rol = ? WHERE username = ?");
            $edicionRolUsuario->bind_param("is", $idRol,$username);
            return $edicionRolUsuario->execute();
        }

        public function establecerConexion() {
            if ($this->conexion == null) {
                $this->conexion = new mysqli($this->host, $this->usuario, $this->clave, $this->db) or die(mysqli_error());
            }
        }

        public function cerrarConexion() {
            $this->conexion = null;
        }
    }
?>