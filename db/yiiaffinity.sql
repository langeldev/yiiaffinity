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
    , valoracion        numeric(3,1)    DEFAULT 0.0       
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

--fixture

INSERT INTO roles(rol)
     VALUES ('admin')
           ,('user');

INSERT INTO usuarios(login, nombre, email, password, rol_id)
      VALUES ('admin', 'admin', 'admin@admin.com', 'admin', 1);
INSERT INTO usuarios(login, nombre, email, password)
      VALUES ('Ana28', 'ana', 'ana@ana.com', 'ana');
