CREATE TABLE roles(
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    moderador BOOLEAN NOT NULL,
    gestor BOOLEAN NOT NULL,
    superusuario BOOLEAN NOT NULL,
    CONSTRAINT uk_mod_ges_sup UNIQUE (moderador, gestor, superusuario)
);