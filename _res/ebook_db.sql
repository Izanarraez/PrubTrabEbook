-- CREATE USER
DROP USER IF EXISTS "ebook-admin"@localhost;
CREATE USER "ebook-admin" @localhost IDENTIFIED BY "ebook";
GRANT ALL PRIVILEGES ON * . * TO "ebook-admin" @localhost;

-- CREATE DATABASE
DROP DATABASE IF EXISTS ebook;
CREATE DATABASE         ebook;
USE                     ebook;



-- CREATE TABLES
CREATE TABLE tipos(
  codigo INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(50)
);

CREATE TABLE usuarios(
  id      INT PRIMARY KEY AUTO_INCREMENT,
  usuario VARCHAR(50) NOT NULL,
  correo  VARCHAR(100) NOT NULL UNIQUE,
  tipo    INT,
  foto    longblob DEFAULT NULL
);

CREATE TABLE passwords(
	id_usuario  INT PRIMARY KEY,
  password    VARCHAR(100) NOT NULL
);

CREATE TABLE datos(
  id_usuario        INT PRIMARY KEY,
  nombre            VARCHAR(30),
  apellidos         VARCHAR(30),
  genero            VARCHAR(100),
  fecha_nacimiento  DATE,
  direccion         VARCHAR(255),
  pais              VARCHAR(100),
  tarjeta           VARCHAR(20)
);



CREATE TABLE libros(
  id            INT PRIMARY KEY AUTO_INCREMENT,
  titulo        VARCHAR(255) NOT NULL,
  subtitulo     VARCHAR(255) NULL,
  resumen       TEXT NOT NULL
);

CREATE TABLE autores(
  id			      INT PRIMARY KEY AUTO_INCREMENT,
  nombre        VARCHAR(255) NOT NULL
);

CREATE TABLE libros_autores(
  id_libro INT NOT NULL,
  id_autor INT NOT NULL
);

CREATE TABLE generos(
  id 			    INT PRIMARY KEY AUTO_INCREMENT,
  nombre		  VARCHAR(255) NOT NULL,
  imagen		  longblob ,
  descripcion	VARCHAR(255) NULL
);

CREATE TABLE libros_generos(
  id_libro 	INT NOT NULL,
  id_genero INT NOT NULL
);

CREATE TABLE formatos(
  nombre	VARCHAR(10) PRIMARY KEY
);

CREATE TABLE idiomas(
  id		  VARCHAR(3) PRIMARY KEY,
  idioma	VARCHAR(255) NOT NULL
);

CREATE TABLE libros_formatos_idiomas(
  id 			    INT PRIMARY KEY AUTO_INCREMENT,
  id_libro    INT NOT NULL,
  id_formato  VARCHAR(10) NOT NULL,
  id_idioma   VARCHAR(2) NOT NULL,
  titulo      VARCHAR(255) NOT NULL,
  archivo     longblob ,
  portada     longblob ,
  paginas		  INT NULL,
  isbn			  VARCHAR(13) NULL,
  precio      DECIMAL NOT NULL 
);



-- ADD FOREIGN KEYS
ALTER TABLE usuarios
	ADD CONSTRAINT UsuarioTiposId FOREIGN KEY (tipo) REFERENCES tipos (codigo)
  ON DELETE SET NULL;
    
ALTER TABLE passwords
	ADD CONSTRAINT PasswordUsuarioId FOREIGN KEY (id_usuario) REFERENCES usuarios (id)
  ON DELETE CASCADE;
    
ALTER TABLE datos
	ADD CONSTRAINT DatosUsuarioId FOREIGN KEY (id_usuario) REFERENCES usuarios (id)
  ON DELETE CASCADE;

ALTER TABLE libros_autores
	ADD CONSTRAINT LibroIdAutor FOREIGN KEY (id_libro) REFERENCES libros (id)
  ON DELETE CASCADE,
  ADD CONSTRAINT LibroAutorId FOREIGN KEY (id_autor) REFERENCES autores (id)
  ON DELETE CASCADE;
  
ALTER TABLE libros_generos
	ADD CONSTRAINT LibroIdGenero FOREIGN KEY (id_libro) REFERENCES libros (id)
  ON DELETE CASCADE,
  ADD CONSTRAINT LibroGeneroId FOREIGN KEY (id_genero) REFERENCES generos (id)
  ON DELETE CASCADE;
  
ALTER TABLE libros_formatos_idiomas
	ADD CONSTRAINT LibroIdFormatoIdioma FOREIGN KEY (id_libro) REFERENCES libros (id)
  ON DELETE CASCADE,
  ADD CONSTRAINT LibroFormatoIdIdioma FOREIGN KEY (id_formato) REFERENCES formatos (nombre)
  ON DELETE CASCADE,
  ADD CONSTRAINT LibroFormatoIomaId FOREIGN KEY (id_idioma) REFERENCES idiomas (id)
  ON DELETE CASCADE;



-- INSERT MOCK DATA
INSERT INTO tipos (nombre) VALUES 
("Invitado"     ),
("Cliente"      ),
("Vendedor"     ),
("Administrador");

INSERT INTO usuarios (usuario, correo, tipo, foto) VALUES 
("Teresa",      "tere@ebook.es",    4, null), -- #1
("Kassito",     "pablo@gmail.es",   2, null), -- #2
("pan_narrans", "alex@perez.com",   3, null), -- #3
("Izan",        "izan@gmail.es",    2, null); -- #4

INSERT INTO datos (id_usuario, nombre, apellidos, genero, fecha_nacimiento, direccion, pais, tarjeta) VALUES 
(1, "Teresa", "V??zquez",  "mujer",  "1990-07-22", "Calle escofina, 12",   "Espa??a", null),
(2, "Pablo",  "Casanova", "hombre", "1989-02-12", "Calle marfil, 45",     "Espa??a", null),
(3, "Alex",   "P??rez",    "hombre", "1996-11-23", "Calle manzana, 09",    "Espa??a", null),
(4, "Izan",   "Arraez",   "hombre", "2000-01-30", "Calle carpinteros, 81","Espa??a", null);

INSERT INTO passwords (id_usuario, password) VALUES 
(1, "aaAA11!!" ),
(2, "aaAA11!!" ),
(3, "aaAA11!!" ),
(4, "aaAA11!!" );

INSERT INTO autores (nombre) VALUES
("Carlos Ruiz Zaf??n"       ),  -- #1
("Brandon Sanderson"       ),  -- #2
("Aranzazu Serrano Lorenzo"),  -- #3
("Terry Pratchett"         ),  -- #4
("Miguel de Cervantes"     ),  -- #5
("Michael Ende"            ),  -- #6
("Frank Herbert"           ),  -- #7
("Neil Gaiman"             );  -- #8



INSERT INTO generos (nombre) VALUES
("Fantas??a"       ),  -- #1
("Suspense"       ),  -- #2
("Terror"         ),  -- #3
("Ciencia Ficci??n"),  -- #4
("Polic??aca"      ),  -- #5
("Romance"        ),  -- #6
("Juvenil"        );  -- #7

INSERT INTO formatos (nombre) VALUES
("PDF"  ),
("EPUB" ),
("MOVI" );

INSERT INTO idiomas (id, idioma) VALUES
("EN", "Ingl??s" ),
("ES", "Espa??ol"),
("FR", "Franc??s");


-- INSERT INTO libros (titulo, subtitulo, resumen) VALUES
-- ("Marina", null, "En la Barcelona de 1980 ??scar Drai sue??a despierto, deslumbrado por los palacetes modernistas cercanos al internado en el que estudia. En una de sus escapadas conoce a Marina, que comparte con ??scar la aventura de adentrarse en un enigma doloroso del pasado de la ciudad. Un misterioso personaje de la posguerra se propuso el mayor desaf??o imaginable, pero su ambici??n lo arrastr?? por sendas siniestras cuyas consecuencias debe pagar alguien todav??a hoy."),
-- ("Neimhaim", "Los hijos de la nieve y la tormenta", "Toda la fuerza de los mitos vikingos y el misticismo de la cultura celta se unen en Neimhaim, una aventura n??rdica cargada de batallas, intrigas y romance; una obra de fantas??a ??pica que despliega un mundo propio dotado de gran riqueza descriptiva."),
-- ("Dune",  null, "Hay mucha arena y los ricos se pegan por la especia que a veces se encuentra en ella. Se l??a parda."),
-- ("Dune Mes??as", null, "Se l??o parda, pero a??n quedan cosas. Hay un poco de depresi??n y mucho desierto, otra vez."),
-- ("Good Omens", null, "The apocalypse is now and a demon and an angel must team up to prevent the destruction of the earth by the antichrist.");

-- INSERT INTO libros_autores (id_libro, id_autor) VALUES
-- (1, 1),
-- (2, 3),
-- (3, 7),
-- (4, 7),
-- (5, 4),
-- (5, 8);

-- INSERT INTO libros_generos (id_libro, id_genero) VALUES
-- (1, 2),
-- (2, 1),
-- (3, 4),
-- (4, 4),
-- (5, 1),
-- (5, 7);

-- -- Necesitamos el archivo y portadas para subirlos
-- INSERT INTO libros_formatos_idiomas (id_libro, id_formato, id_idioma, titulo, paginas, isbn, archivo, portada, precio) VALUES
-- (1, "PDF",  "ES", "Marina",           304, "9783104012841", null, null, 10),
-- (1, "MOVI", "ES", "Marina",           304, "9783104012841", null, null, 10),
-- (1, "MOVI", "EN", "Marine",           null, null,           null, null, 10),
-- (2, "MOVI", "ES", "Neimhaim",         1082,"9788415831624", null, null, 12),
-- (2, "MOVI", "EN", "Neimhaim",         1082, null,           null, null, 12),
-- (5, "EPUB", "EN", "Good Omens",       null, null,           null, null, 7),
-- (5, "EPUB", "ES", "Buenos Presagios", null, null,           null, null, 7);