------------------------------
-- Archivo de base de datos --
------------------------------

--Productos
DROP TABLE IF EXISTS productos CASCADE;
CREATE TABLE productos
(
      id                bigserial       PRIMARY KEY
    , titulo            varchar(255)    NOT NULL
    , titulo_original   varchar(255)    NOT NULL
    , anyo              numeric(4)      NOT NULL  CONSTRAINT ck__anyo CHECK (anyo >= 0)
    , duracion          smallint        NOT NULL  CONSTRAINT ck_producto_duracion CHECK (duracion >= 1)
    , pais              varchar(255)    NOT NULL
    , sinopsis          text            NOT NULL     
);

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
    , nombre            varchar(255)    NOT NULL

);

DROP TABLE IF EXISTS productos_premios CASCADE;
CREATE TABLE productos_premios
(
      producto_id bigint REFERENCES productos(id)
    , premio_id bigint REFERENCES premios(id)
    , PRIMARY KEY (producto_id, premio_id)
);


--Usuarios
DROP TABLE IF EXISTS roles CASCADE;

CREATE TABLE roles
(
      id                bigserial      PRIMARY KEY
    , rol               varchar(16)
);

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


DROP TABLE IF EXISTS listas_productos CASCADE;
CREATE TABLE listas_productos
(
      lista_id bigint REFERENCES listas(id) ON DELETE CASCADE
    , producto_id bigint REFERENCES productos(id) ON DELETE CASCADE
    , PRIMARY KEY (producto_id, lista_id)
);

--fixture
INSERT INTO roles(rol)
     VALUES ('admin')
           ,('user');

INSERT INTO usuarios(login, nombre, email, password, rol_id)
      VALUES ('admin', 'admin', 'admin@admin.com', crypt('admin', gen_salt('bf', 10)), 1);
