CREATE TABLE eventos(
	id_evento INT AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(100) NOT NULL,
	organizador VARCHAR(100),
	fecha DATE NOT NULL,
	hora TIME NOT NULL,
	lugar VARCHAR(100) NOT NULL,
	url VARCHAR(512),
	descripcion VARCHAR(1024),
	url_portada VARCHAR(512)
);
