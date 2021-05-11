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
    , imagen           text
);

CREATE INDEX idx_titulo on productos(titulo);

DROP TABLE IF EXISTS personas CASCADE;
CREATE TABLE personas
(
      id                bigserial       PRIMARY KEY
    , nombre            varchar(255)    NOT NULL
);


DROP TABLE IF EXISTS productos_directores CASCADE;
CREATE TABLE productos_directores
(
      producto_id bigint REFERENCES productos(id) ON DELETE CASCADE
    , persona_id bigint REFERENCES personas(id) ON DELETE CASCADE
    , PRIMARY KEY (producto_id, persona_id)
);

DROP TABLE IF EXISTS productos_guionistas CASCADE;
CREATE TABLE productos_guionistas
(
      producto_id bigint REFERENCES productos(id) ON DELETE CASCADE
    , persona_id bigint REFERENCES personas(id) ON DELETE CASCADE
    , PRIMARY KEY (producto_id, persona_id)
);

DROP TABLE IF EXISTS productos_musica CASCADE;
CREATE TABLE productos_musica
(
      producto_id bigint REFERENCES productos(id) ON DELETE CASCADE
    , persona_id bigint REFERENCES personas(id) ON DELETE CASCADE
    , PRIMARY KEY (producto_id, persona_id)
);

DROP TABLE IF EXISTS fotografia CASCADE;

DROP TABLE IF EXISTS productos_fotografia CASCADE;
CREATE TABLE productos_fotografia
(
      producto_id bigint REFERENCES productos(id) ON DELETE CASCADE
    , persona_id bigint REFERENCES personas(id) ON DELETE CASCADE
    , PRIMARY KEY (producto_id, persona_id)
);

DROP TABLE IF EXISTS productos_interpretes CASCADE;
CREATE TABLE productos_interpretes
(
      producto_id bigint REFERENCES productos(id) ON DELETE CASCADE
    , persona_id bigint REFERENCES personas(id) ON DELETE CASCADE
    , PRIMARY KEY (producto_id, persona_id)
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
      producto_id bigint REFERENCES productos(id) ON DELETE CASCADE
    , productora_id bigint REFERENCES productoras(id) ON DELETE CASCADE
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
      producto_id bigint REFERENCES productos(id) ON DELETE CASCADE
    , genero_id bigint REFERENCES generos(id) ON DELETE CASCADE
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
    , recover            varchar(255)
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
    , valoracion  numeric(2)    NOT NULL
    , titulo      varchar(255)  NOT NULL
    , critica     text          NOT NULL
    , created_at  timestamp(0)  NOT NULL DEFAULT CURRENT_TIMESTAMP
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
      , UNIQUE (usuario_id, lista_id)

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
           , ('jose', 'jose', 'jose@pepe.com', crypt('jose', gen_salt('bf', 10)), 1985, 'Mujer', 'España', 'Cádiz')
           , ('demo', 'demo', 'demo@demo.com', crypt('demo', gen_salt('bf', 10)), 1985, 'No binario', 'España', 'Sevilla');


INSERT INTO tipos(nombre)
     VALUES ('Película')
          , ('Serie')
          , ('Documental');     


INSERT INTO productos(titulo, titulo_original, anyo, duracion, tipo_id,pais, sinopsis)
     VALUES ('Moolight', 'Moolight', 2016, 111, 1,'Estados Unidos', 'La difícil infancia, adolescencia y madurez de un chico afroamericano que crece en una zona conflictiva de Miami. A medida que pasan los años, el joven se descubre a sí mismo y encuentra el amor en lugares inesperados.')
          , ('Shutter Island', 'Shutter Island', 2010, 138, 1,'Estados Unidos','En el verano de 1954, los agentes judiciales Teddy Daniels (DiCaprio) y Chuck Aule (Ruffalo) son destinados a una remota isla del puerto de Boston para investigar la desaparición de una peligrosa asesina (Mortimer) que estaba recluida en el hospital psiquiátrico Ashecliffe, un centro penitenciario para criminales perturbados dirigido por el siniestro doctor John Cawley (Kingsley). Pronto descubrirán que el centro guarda muchos secretos y que la isla esconde algo más peligroso que los pacientes. Thriller psicológico basado en la novela homónima de Dennis Lehane (autor de "Mystic River" y "Gone Baby Gone").')
          , ('Zoolander', 'Zoolander', 2001, 89, 1,'Estados Unidos', 'Derek Zoolander (Stiller) ha sido el modelo masculino más cotizado durante los últimos tres años. La noche de la gala que podría suponer su cuarta corona, el galardón se lo lleva un nuevo modelo llamado Hansel (Wilson). Derek queda en entredicho y como un idiota, y decide retirarse. Sin embargo, un prestigioso diseñador le pide que desfile para él.')
          , ('Múltiple', 'Split', 2016, 116, 1,'Estados Unidos', 'A pesar de que Kevin (James McAvoy) le ha demostrado a su psiquiatra de confianza, la Dra. Fletcher (Betty Buckley), que posee 23 personalidades diferentes, aún queda una por emerger, decidida a dominar a todas las demás. Obligado a raptar a tres chicas adolescentes encabezadas por la decidida y observadora Casey (Anya Taylor-Joy), Kevin lucha por sobrevivir contra todas sus personalidades y la gente que le rodea, a medida que las paredes de sus compartimentos mentales se derrumban.')
          , ('El día de la bestia', 'El día de la bestia', 1995, 103, 1,'España', 'Un sacerdote cree haber descifrado el mensaje secreto del Apocalipsis según San Juan: el Anticristo nacerá el 25 de diciembre de 1995 en Madrid. Para impedir el nacimiento del hijo de Satanás, el cura se alía con José María, un joven aficionado al death metal. Ambos intentan averiguar en qué parte de Madrid tendrá lugar el apocalíptico acontecimiento. Con la ayuda del profesor Cavan, presentador de un programa de televisión de carácter esotérico y sobrenatural, el cura y José Mari invocan al diablo en una extraña ceremonia.')
          , ('Crimen ferpecto', 'Crimen ferpecto', 2001, 106, 1,'España', 'Rafael es un tipo seductor y ambicioso. Le gustan las mujeres guapas, la ropa elegante y el ambiente selecto. Trabaja en unos grandes almacenes. Ha convertido la sección de señoras en su feudo particular. Nació para vender. Lo lleva en la sangre. Rafael aspira a convertirse en el nuevo Jefe de Planta. Su principal rival para ocupar el puesto es Don Antonio, el veterano encargado de la sección de Caballeros. Por fatalidades del destino, Don Antonio muere accidentalmente tras una discusión acalorada. El único testigo del crimen es Lourdes, una dependienta horrorosa, naïf y obsesiva, que no duda en chantajear a Rafael para que se convierta en su amante, su marido y su esclavo. Rafael se desespera viendo cómo su mundo sofisticado degenera poco a poco en un infierno de vulgaridad. Preso de la locura, idea un plan infalible para librarse de Lourdes. Esta vez no puede permitirse ni un error. Todo tiene que ser "ferpecto".')
          , ('Dark', 'Dark', 2017, 60, 2, 'Alemania', 'Serie de TV (2017-2020). 3 temporadas. 26 episodios. Tras la desaparición de un joven, cuatro familias desesperadas tratan de entender lo ocurrido a medida que van desvelando un retorcido misterio que abarca tres décadas... Saga familiar con un giro sobrenatural, "Dark" se sitúa en un pueblo alemán, donde dos misteriosas desapariciones dejan al descubierto las dobles vidas y las relaciones resquebrajadas entre estas cuatro familias.')
          , ('La maldición de Hill House', 'The Haunting of Hill House', 2018, 60, 2, 'Estados Unidos', 'Serie de TV (2018). 10 episodios. Un grupo de hermanos crece en lo que acaba convirtiéndose en la casa encantada más famosa del país. Ya como adultos, viéndose obligados a reunirse tras una tragedia, la familia tendrá que afrontar los fantasmas del pasado... Adaptación de la novela homónima de Shirley Jackson.')
          , ('Chicago Boys', 'Chicago Boys', 2015, 85, 3, 'Chile', 'En plena Guerra Fría la Universidad de Chicago becó a un grupo de estudiantes chilenos para ir a estudiar economía bajo las enseñanzas de Milton Friedman. 20 años después, en plena dictadura, cambiaron el destino de Chile y lo convirtieron en el bastión del neoliberalismo en el mundo. Ésta es la historia de los Chicago Boys contada por ellos mismos: ¿qué estuvieron dispuestos a hacer con tal de lograr sus objetivos? ¿Cómo nació el modelo que hoy está en jaque? ¿Cómo explican los resultados en el largo plazo?');

INSERT INTO personas(nombre)
     VALUES ('Barry Jenkins')
          , ('Nicholas Britel')
          , ('James Laxton')
          , ('Travent Rhodes') 
          , ('Naomie Harries') 
          , ('Mahershala Ali')
          , ('Ashton Sanders') 
          , ('André Holland')
          , ('Alex R, Hibbert') 
          , ('Martin Scorcese')
          , ('Laeta Kalogridis')
          , ('Roberto Richarson')
          , ('Leonardo Dicaprio')
          , ('Mark Ruffalo')
          , ('Ben Kingsley')
          , ('Emily Mortimer')
          , ('Michelle Williams')
          , ('Patricia Clarkson')
          , ('Ben Stiller')
          , ('Drake Arnold')
          , ('John Hamburg')
          , ('Varios')
          , ('Barry Peterson')
          , ('Milla Jovovich')
          , ('Owen Wilson')
          , ('M. Night Shyamalan')
          , ('Mike Gioulakis')
          , ('West Thorsdson')
          , ('James McAvoy')
          , ('Anya Taylor-Joy')
          , ('Betty Buckley')
          , ('Álex de la Iglesia')
          , ('Jorge Guerricaechevarría')
          , ('Battista Lena')
          , ('David Arnold')
          , ('Flavio Martínez Labiano')
          , ('Álex Angulo')
          , ('Santiago Seguro')
          , ('Roque Baños')
          , ('José L. Moreno')
          , ('Guillermo Toledo')
          , ('Mónica Cervera')
          , ('Luis Valera')
          , ('Kira Miró')
          , ('Baran bo Odar')
          , ('Martin Behnke')
          , ('Jantje Friese')
          , ('Ben Frost')
          , ('Nikolaus Summerer')
          , ('Louis Hofmann')
          , ('Anna König')
          , ('Roland Wolf')
          , ('Mike Flanagan')
          , ('The Newton Brothers')
          , ('Michiel Huisman')
          , ('Carla Gugino')
          , ('Carola Fuentes')
          , ('Rafael Valdeavellano')
          , ('Gabriel Pulido')
          , ('Pablo Valdés')
          , ('Sebastián Caro')
          , ('Arnold Harberger')
          , ('Sergio De Castro')
          , ('Ernesto Fontaine')
          , ('Ricardo Ffrench-Davis');

INSERT INTO productos_directores(producto_id, persona_id)
     VALUES (1,1)
          , (2,10)
          , (3,19)
          , (4,26)
          , (5,32)
          , (6,32)
          , (7,45)
          , (7,46)
          , (8,53)
          , (9,57)
          , (9,58);

INSERT INTO productos_guionistas(producto_id, persona_id)
     VALUES (1,1)
          , (2,11)
          , (3,19)
          , (3,20)
          , (3,21)
          , (4,26)
          , (5,32)
          , (5,33)
          , (6,32)
          , (6,33)
          , (7,47)
          , (7,45)
          , (8,53)
          , (9,57)
          , (9,58);


INSERT INTO productos_musica(producto_id, persona_id)
     VALUES (1,2)
          , (2,22)
          , (3,35)
          , (4,28)
          , (5,34)
          , (6,39)
          , (6,48)
          , (8,54)
          , (9,59);


INSERT INTO productos_fotografia(producto_id, persona_id)
     VALUES (1,3)
          , (2,12)
          , (3,23)
          , (4,27)
          , (5,36)
          , (6,40)
          , (7,49)
          , (9,60)
          , (9,61);

INSERT INTO productos_interpretes(producto_id, persona_id)
     VALUES (1,4)
          , (1,5)
          , (1,6)
          , (1,7)
          , (1,8)
          , (1,9)
          , (2,13)
          , (2,14)
          , (2,15)
          , (2,16)
          , (2,17)
          , (2,18)
          , (3,19)
          , (3,25)
          , (3,24)
          , (4,29)
          , (4,30)
          , (4,31)
          , (5,37)
          , (5,38)
          , (6,41)
          , (6,42)
          , (6,43)
          , (6,44)
          , (7,50)
          , (7,51)
          , (7,52)
          , (8,55)
          , (8,56)
          , (9,62)
          , (9,63)
          , (9,64)
          , (9,65);

INSERT INTO productoras(nombre)
     VALUES ('A24')
          , ('Plan B Entertainment')
          , ('PASTEL')
          , ('Paramount Pictures')
          , ('Phoenix Pictures')
          , ('Sikelia Productions')
          , ('Red Hour')
          , ('Blinding Edge Pictures')
          , ('Iberoamericana')
          , ('Canal+ España')
          , ('Pánico Films')
          , ('Sogecine')
          , ('Wiedemann & Berg Television (Distribuidora: Netflix)')
          , ('Paramount Television')
          , ('La Ventana Cine');

INSERT INTO productos_productoras(producto_id, productora_id) 
     VALUES (1,1)
          , (1,2)
          , (1,3)
          , (2,4)
          , (2,5)
          , (2,6)
          , (3,4)
          , (3,7)
          , (4,8)
          , (5,9)
          , (5,10)
          , (6,11)
          , (6,12)
          , (7,13)
          , (8,14)
          , (9,15);

INSERT INTO generos(nombre)
     VALUES ('Drama')
          , ('Drogas')
          , ('Terror')
          , ('Thiller')
          , ('Intriga')
          , ('Comedia')
          , ('Parodia')
          , ('Comedia')
          , ('Acción')
          , ('Romance')
          , ('Documental sobre historia');

INSERT INTO productos_generos(producto_id, genero_id)
     VALUES (1,1)
          , (1,2)
          , (2,4)
          , (2,5)
          , (3,6)
          , (3,7)
          , (4,4)
          , (4,5)
          , (5,8)
          , (5,9)
          , (5,3)
          , (6,8)
          , (6,10)
          , (6,4)
          , (7,1)
          , (8,1)
          , (8,3)
          , (9,11);

INSERT INTO premios(producto_id,nombre, cantidad)
     VALUES (1, 'Oscar', 3)
          , (1, 'Globos de Oro', 1);

INSERT INTO valoraciones(producto_id, usuario_id, valoracion)
    VALUES (1, 3, 5)
         , (1, 4, 7)
         , (2, 3, 8)
         , (2, 5, 9)
         , (2, 6, 3)
         , (3, 3, 10);

INSERT INTO listas(titulo)
     VALUES ('Mis películas favoritas')
          , ('Mis series favoritas')
          , ('Películas sobrevaloradas')
          , ('Mis films de terror preferidos');
