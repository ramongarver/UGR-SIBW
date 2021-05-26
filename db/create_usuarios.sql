CREATE TABLE usuarios(
     id_usuario INT AUTO_INCREMENT PRIMARY KEY,
     username VARCHAR(31) NOT NULL UNIQUE,
     password VARCHAR(255) NOT NULL,
     id_rol INT NOT NULL,
     nombre VARCHAR(31) NOT NULL,
     apellidos VARCHAR(63) NOT NULL,
     email VARCHAR(320) NOT NULL,
     telefono VARCHAR(31) NOT NULL,
     fecha_nacimiento DATE NOT NULL,
     fecha_registro DATE NOT NULL,
     genero ENUM('H', 'M', 'O') NOT NULL,
     CONSTRAINT fk_usuario_rol FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);