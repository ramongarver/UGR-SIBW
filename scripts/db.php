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

        public function obtenerEvento($idEvento) {
            $infoEvento = $this->conexion->prepare("SELECT id_evento, nombre, organizador, fecha, hora, lugar, url, descripcion FROM eventos WHERE id_evento = ?");
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

        public function obtenerImagenes($idEvento) {
            $infoImagenes = $this->conexion->prepare("SELECT id_imagen, autor, year, descripcion, path FROM imagenes WHERE id_evento = ?");
            $infoImagenes->bind_param("i", $idEvento);
            $infoImagenes->execute();
            $infoImagenes = $infoImagenes->get_result();
            return $infoImagenes->fetch_all(MYSQLI_ASSOC);
        }

        public function obtenerComentarios($idEvento) {
            $infoComentarios = $this->conexion->prepare("SELECT id_comentario, nombre, fecha, comentario FROM comentarios WHERE id_evento = ?");
            $infoComentarios->bind_param("i", $idEvento);
            $infoComentarios->execute();
            $infoComentarios = $infoComentarios->get_result();
            return $infoComentarios->fetch_all(MYSQLI_ASSOC);
        }

        public function obtenerPalabrotas() {
            $infoPalabrotas = $this->conexion->query("SELECT palabrota FROM palabrotas");
            return $infoPalabrotas->fetch_all(MYSQLI_ASSOC);
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