CREATE TABLE etiquetas(
    id_etiqueta INT UNIQUE NOT NULL,
    id_evento INT NOT NULL,
    etiqueta VARCHAR(50) UNIQUE NOT NULL,
    CONSTRAINT fk_evento_etiqueta FOREIGN KEY (id_evento) REFERENCES eventos(id_evento),
    CONSTRAINT pk_etiqueta PRIMARY KEY(id_evento, id_etiqueta)
);