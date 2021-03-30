------------------------------
-- Archivo de base de datos --
------------------------------

--Productos
DROP TABLE IF EXISTS tipos CASCADE;
CREATE TABLE tipos
(
     id bigserial PRIMARY KEY
   , nombre varchar(255) NOT NULL
);

DROP INDEX IF EXISTS idx_titulo;
DROP TABLE IF EXISTS productos CASCADE;
CREATE TABLE productos
(
      id                bigserial       PRIMARY KEY
    , titulo            varchar(255)    NOT NULL
    , titulo_original   varchar(255)    NOT NULL
    , anyo              numeric(4)      NOT NULL  CONSTRAINT ck__anyo CHECK (anyo >= 0)
    , duracion          smallint        NOT NULL  CONSTRAINT ck_producto_duracion CHECK (duracion >= 1)  
    , tipo_id           bigint          NOT NULL  REFERENCES tipos(id)
    , pais              varchar(255)    NOT NULL
    , sinopsis          text            NOT NULL     
);

CREATE INDEX idx_titulo on productos(titulo);

DROP TABLE IF EXISTS directores CASCADE;
CREATE TABLE directores
(
      id                bigserial       PRIMARY KEY
    , nombre            varchar(255)    NOT NULL
);

DROP TABLE IF EXISTS productos_directores CASCADE;
CREATE TABLE productos_directores
(
      producto_id bigint REFERENCES productos(id)
    , director_id bigint REFERENCES directores(id)
    , PRIMARY KEY (producto_id, director_id)
);

DROP TABLE IF EXISTS guionistas CASCADE;
CREATE TABLE guionistas
(
      id                bigserial       PRIMARY KEY
    , nombre            varchar(255)    NOT NULL
);

DROP TABLE IF EXISTS productos_guionistas CASCADE;
CREATE TABLE productos_guionistas
(
      producto_id bigint REFERENCES productos(id)
    , guion_id bigint REFERENCES guionistas(id)
    , PRIMARY KEY (producto_id, guion_id)
);

DROP TABLE IF EXISTS musica CASCADE;
CREATE TABLE musica
(
      id                bigserial       PRIMARY KEY
    , nombre            varchar(255)    NOT NULL
);

DROP TABLE IF EXISTS productos_musica CASCADE;
CREATE TABLE productos_musica
(
      producto_id bigint REFERENCES productos(id)
    , musica_id bigint REFERENCES musica(id)
    , PRIMARY KEY (producto_id, musica_id)
);

DROP TABLE IF EXISTS fotografia CASCADE;
CREATE TABLE fotografia
(
      id                bigserial       PRIMARY KEY
    , nombre            varchar(255)    NOT NULL
);

DROP TABLE IF EXISTS productos_fotografia CASCADE;
CREATE TABLE productos_fotografia
(
      producto_id bigint REFERENCES productos(id)
    , fotografia_id bigint REFERENCES fotografia(id)
    , PRIMARY KEY (producto_id, fotografia_id)
);

DROP TABLE IF EXISTS interpretes CASCADE;
CREATE TABLE interpretes
(
      id                bigserial       PRIMARY KEY
    , nombre            varchar(255)    NOT NULL
);

DROP TABLE IF EXISTS productos_interpretes CASCADE;
CREATE TABLE productos_interpretes
(
      producto_id bigint REFERENCES productos(id)
    , interprete_id bigint REFERENCES interpretes(id)
    , PRIMARY KEY (producto_id, interprete_id)
);

DROP TABLE IF EXISTS productoras CASCADE;
CREATE TABLE productoras
(
      id                bigserial       PRIMARY KEY
    , nombre            varchar(255)    NOT NULL
);

DROP TABLE IF EXISTS productos_productoras CASCADE;
CREATE TABLE productos_productoras
(
      producto_id bigint REFERENCES productos(id)
    , productora_id bigint REFERENCES productoras(id)
    , PRIMARY KEY (producto_id, productora_id)
);

DROP TABLE IF EXISTS generos CASCADE;

CREATE TABLE generos
(
      id                bigserial       PRIMARY KEY
    , nombre            varchar(255)    NOT NULL
);

DROP TABLE IF EXISTS productos_generos CASCADE;
CREATE TABLE productos_generos
(
      producto_id bigint REFERENCES productos(id)
    , genero_id bigint REFERENCES generos(id)
    , PRIMARY KEY (producto_id, genero_id)
);

DROP TABLE IF EXISTS premios CASCADE;
CREATE TABLE premios
(
      id                bigserial       PRIMARY KEY
    , producto_id       bigint          NOT NULL      REFERENCES productos(id) ON DELETE CASCADE
    , cantidad          smallint        NOT NULL      CONSTRAINT ck_premios CHECK (cantidad >= 1)
    , nombre            varchar(255)    NOT NULL

);


--Usuarios
DROP TABLE IF EXISTS roles CASCADE;

CREATE TABLE roles
(
      id                bigserial      PRIMARY KEY
    , rol               varchar(16)
);

DROP INDEX IF EXISTS idx_login;
DROP INDEX IF EXISTS idx_nombre;
DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
      id                 bigserial     PRIMARY KEY
    , login              varchar(255)  NOT NULL UNIQUE 
    , nombre             varchar(255)
    , anyo_nac           numeric(4)    CONSTRAINT ck_usuarios_anyo CHECK (anyo_nac >= 0)
    , email              varchar(255)  NOT NULL UNIQUE
    , password           varchar(80)   NOT NULL
    , auth_key           varchar(255)
    , rol_id             bigint        NOT NULL DEFAULT 2 REFERENCES roles(id) 
    , genero             varchar(16)
    , pais               varchar(255)
    , ciudad             varchar(255)
);

CREATE INDEX idx_login on usuarios(login);
CREATE INDEX idx_nombre on usuarios(nombre);

DROP TABLE IF EXISTS valoraciones CASCADE;
CREATE TABLE valoraciones
(
        producto_id   bigint    REFERENCES productos(id) ON DELETE CASCADE
      , usuario_id    bigint    REFERENCES usuarios(id)  ON DELETE CASCADE
      , valoracion    numeric(2)
      , PRIMARY KEY (producto_id, usuario_id)
);

DROP TABLE IF EXISTS criticas CASCADE;

CREATE TABLE criticas
(
      id          bigserial     PRIMARY KEY
    , producto_id bigint        NOT NULL REFERENCES productos(id) ON DELETE CASCADE 
    , usuario_id  bigint        NOT NULL REFERENCES usuarios(id)  ON DELETE CASCADE
    , valoracion  numeric(2)        
    , titulo      varchar(255)  NOT NULL
    , critica     text          NOT NULL
    , created_at  timestamp(0)  DEFAULT CURRENT_TIMESTAMP
    , UNIQUE (producto_id, usuario_id)
);


DROP TABLE IF EXISTS listas CASCADE;
CREATE TABLE listas
(
        id          bigserial       PRIMARY KEY
      , titulo      varchar(255)    NOT NULL
);

DROP TABLE IF EXISTS usuarios_listas CASCADE;
CREATE TABLE usuarios_listas
(
         id bigserial PRIMARY KEY
      ,  usuario_id bigint REFERENCES usuarios(id) ON DELETE CASCADE
      ,  lista_id bigint REFERENCES listas(id) ON DELETE CASCADE

);

DROP TABLE IF EXISTS listas_productos CASCADE;
CREATE TABLE listas_productos
(
      id                 bigserial     PRIMARY KEY
    , lista_id bigint REFERENCES usuarios_listas(id) ON DELETE CASCADE
    , producto_id bigint REFERENCES productos(id) ON DELETE CASCADE
    , posicion bigint
    , UNIQUE (producto_id, lista_id)
);

--fixture
INSERT INTO roles(rol)
     VALUES ('admin')
           ,('user');

INSERT INTO usuarios(login, nombre, email, password, rol_id)
      VALUES ('admin', 'admin', 'admin@admin.com', crypt('admin', gen_salt('bf', 10)), 1)
           , ('admin2', 'admin2', 'admin2@admin.com', crypt('admin2', gen_salt('bf', 10)), 1);
INSERT INTO usuarios(login, nombre, email, password, anyo_nac, genero, pais, ciudad)
      VALUES ('ana', 'ana', 'ana@ana.com', crypt('ana', gen_salt('bf', 10)), 1990, 'Mujer', 'España', 'Murcia')
           , ('pepe', 'pepe', 'pepe@pepe.com', crypt('pepe', gen_salt('bf', 10)), 2002, 'Hombre', 'España', 'Madrid')
           , ('jose', 'jose', 'jose@pepe.com', crypt('jose', gen_salt('bf', 10)), 1985, 'Mujer', 'España', 'Cádiz');


INSERT INTO tipos(nombre)
     VALUES ('Película')
          , ('Serie')
          , ('Documental');     


INSERT INTO productos(titulo, titulo_original, anyo, duracion, tipo_id,pais, sinopsis)
     VALUES ('Moolight', 'Moolight', 2016, 111, 1,'Estados Unidos', 'La difícil infancia, adolescencia y madurez de un chico afroamericano que crece en una zona conflictiva de Miami. A medida que pasan los años, el joven se descubre a sí mismo y encuentra el amor en lugares inesperados.');

INSERT INTO directores(nombre)
     VALUES ('Barry Jenkins');

INSERT INTO productos_directores(producto_id, director_id)
     VALUES (1,1);

INSERT INTO guionistas(nombre)
     VALUES ('Barry Jenkins');

INSERT INTO productos_guionistas(producto_id, guion_id)
     VALUES (1,1);

INSERT INTO musica(nombre)
     VALUES ('Nicholas Britell');

INSERT INTO productos_musica(producto_id, musica_id)
     VALUES (1,1);

INSERT INTO fotografia(nombre)
     VALUES ('James Laxton');

INSERT INTO productos_fotografia(producto_id, fotografia_id)
     VALUES (1,1);

INSERT INTO interpretes(nombre)
     VALUES ('Travent Rhodes')
          , ('Naomie Harries')
          , ('Mahershala Ali')
          , ('Ashton Sanders')
          , ('André Holland')
          , ('Alex R. Hibbert');

INSERT INTO productos_interpretes(producto_id, interprete_id)
     VALUES (1,1)
          , (1,2)
          , (1,3)
          , (1,4)
          , (1,5)
          , (1,6);

INSERT INTO productoras(nombre)
     VALUES ('A24')
          , ('Plan B Entertainment')
          , ('PASTEL');

INSERT INTO productos_productoras(producto_id, productora_id) 
     VALUES (1,1)
          , (1,2)
          , (1,3);

INSERT INTO generos(nombre)
     VALUES ('Drama')
          , ('Drogas')
          , ('Terror');

INSERT INTO productos_generos(producto_id, genero_id)
     VALUES (1, 1)
          , (1, 2);

INSERT INTO premios(producto_id,nombre, cantidad)
     VALUES (1, 'Oscar', 3)
          , (1, 'Globos de Oro', 1);

INSERT INTO valoraciones(producto_id, usuario_id, valoracion)
    VALUES (1, 3, 5)
         , (1, 4, 7);
