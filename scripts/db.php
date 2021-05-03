<?php
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
            $this->establecerConexion();
            $infoEventos = $this->conexion->query("SELECT id_evento, nombre, fecha, url_portada FROM eventos");
            return $infoEventos->fetch_all(MYSQLI_ASSOC);
        }

        public function obtenerEvento($idEvento) {
            $this->establecerConexion();
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
            $this->establecerConexion();
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
            $this->establecerConexion();
            $infoPalabrotas = $this->conexion->query("SELECT palabrota FROM palabrotas");
            return $infoPalabrotas->fetch_all(MYSQLI_ASSOC);
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