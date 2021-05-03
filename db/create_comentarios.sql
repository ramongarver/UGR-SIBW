CREATE TABLE comentarios(
	id_comentario INT NOT NULL,
	id_evento INT NOT NULL,
	nombre VARCHAR(80) NOT NULL,
	email VARCHAR(320) NOT NULL,
	fecha DATETIME NOT NULL,
	comentario VARCHAR(512) NOT NULL,
	CONSTRAINT fk_evento_comentario FOREIGN KEY (id_evento) REFERENCES eventos(id_evento),
	CONSTRAINT pk_comentario PRIMARY KEY(id_evento, id_comentario)
);
