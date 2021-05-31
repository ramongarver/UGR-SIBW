CREATE TABLE comentarios(
    id_comentario INT NOT NULL,
    id_evento INT NOT NULL,
    id_usuario INT NOT NULL,
    id_moderador INT NOT NULL DEFAULT -1,
    fecha DATETIME NOT NULL,
    comentario VARCHAR(512) NOT NULL,
    CONSTRAINT fk_evento_comentario FOREIGN KEY (id_evento) REFERENCES eventos(id_evento),
    CONSTRAINT fk_autor_comentario FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    CONSTRAINT pk_comentario PRIMARY KEY(id_evento, id_comentario)
);