CREATE TABLE imagenes(
	id_imagen INT UNIQUE NOT NULL,
	id_evento INT NOT NULL,
	autor VARCHAR(50) NOT NULL DEFAULT 'Desconocido',
	year YEAR,
	descripcion VARCHAR(30),
	path VARCHAR(512) NOT NULL,
	CONSTRAINT fk_evento_imagen FOREIGN KEY (id_evento) REFERENCES eventos(id_evento),
	CONSTRAINT pk_imagen PRIMARY KEY(id_evento, id_imagen)
);