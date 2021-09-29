--
-- ER/Studio 8.0 SQL Code Generation
-- Company :      CASA
-- Project :      dominoAPI.DM1
-- Author :       Dayron
--
-- Date Created : Thursday, May 13, 2021 12:36:28
-- Target DBMS : MySQL 5.x
--

-- 
-- TABLE: arbitro 
--

CREATE TABLE arbitro(
    id                  INT            NOT NULL,
    nivel               VARCHAR(30)    NOT NULL,
    es_internacional    BIT(1)         DEFAULT 0 NOT NULL,
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: boleta 
--

CREATE TABLE boleta(
    evento_id         INT         NOT NULL,
    numero            INT         NOT NULL,
    numero_ronda      SMALLINT    NOT NULL,
    numero_mesa       SMALLINT    NOT NULL,
    fecha_registro    CHAR(10),
    es_valida         BIT(1)      DEFAULT 1 NOT NULL,
    PRIMARY KEY (evento_id, numero, numero_ronda, numero_mesa)
)ENGINE=MYISAM
;



-- 
-- TABLE: boleta_equipo 
--

CREATE TABLE boleta_equipo(
    equipo_id       INT         NOT NULL,
    evento_id       INT         NOT NULL,
    numero          INT         NOT NULL,
    numero_ronda    SMALLINT    NOT NULL,
    numero_mesa     SMALLINT    NOT NULL,
    salidor         BIT(1)      DEFAULT FALSE NOT NULL,
    tantos          INT         NOT NULL,
    resultado       INT         DEFAULT 0 NOT NULL,
    ganador         BIT(1)      DEFAULT FALSE NOT NULL,
    inicio          DATETIME    NOT NULL,
    duracion        DATETIME,
    PRIMARY KEY (equipo_id, evento_id, numero, numero_ronda, numero_mesa)
)ENGINE=MYISAM
;



-- 
-- TABLE: categoria 
--

CREATE TABLE categoria(
    id             SMALLINT        AUTO_INCREMENT,
    nombre         VARCHAR(120)    NOT NULL,
    descripcion    VARCHAR(255),
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: ciudad 
--

CREATE TABLE ciudad(
    id         INT             AUTO_INCREMENT,
    pais       VARCHAR(120)    NOT NULL,
    pais_id    INT             NOT NULL,
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: comite_organizador 
--

CREATE TABLE comite_organizador(
    persona_id    INT             NOT NULL,
    evento_id     INT             NOT NULL,
    funcion       VARCHAR(120)    NOT NULL,
    PRIMARY KEY (persona_id, evento_id)
)ENGINE=MYISAM
;



-- 
-- TABLE: data 
--

CREATE TABLE data(
    evento_id        INT         NOT NULL,
    numero_data      SMALLINT    NOT NULL,
    numero_boleta    INT         NOT NULL,
    numero_ronda     SMALLINT    NOT NULL,
    numero_mesa      SMALLINT    NOT NULL,
    equipo_id        INT         NOT NULL,
    puntos           INT         NOT NULL,
    PRIMARY KEY (evento_id, numero_data, numero_boleta, numero_ronda, numero_mesa, equipo_id)
)ENGINE=MYISAM
;



-- 
-- TABLE: equipo 
--

CREATE TABLE equipo(
    id        INT            AUTO_INCREMENT,
    nombre    VARCHAR(60)    NOT NULL,
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: evento 
--

CREATE TABLE evento(
    id                 INT             AUTO_INCREMENT,
    ciudad_id          INT             NOT NULL,
    nombre             VARCHAR(255)    NOT NULL,
    tipo_id            SMALLINT        NOT NULL,
    modalidad_id       SMALLINT        NOT NULL,
    categoria_id       SMALLINT        NOT NULL,
    es_internacional   BIT(1)          DEFAULT FALSE NOT NULL,
    es_presencial      BIT(1)          DEFAULT TRUE NOT NULL,
    comentario         VARCHAR(255),
    cerrado            BIT(1)          DEFAULT FALSE NOT NULL,
    fecha_inicio       DATETIME,
    fecha_cierre       DATETIME,
    cantidad_fichas    SMALLINT        DEFAULT 28 NOT NULL,
    creado             DATETIME        NOT NULL,
    actualizado        DATETIME        NOT NULL,
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: jugador 
--

CREATE TABLE jugador(
    id         INT            NOT NULL,
    nivel      VARCHAR(30)    NOT NULL,
    elo        INT            DEFAULT 0 NOT NULL,
    ranking    CHAR(2),
    tipo       CHAR(1),
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: mesa 
--

CREATE TABLE mesa(
    evento_id    INT         NOT NULL,
    numero       SMALLINT    NOT NULL,
    PRIMARY KEY (evento_id, numero)
)ENGINE=MYISAM
;



-- 
-- TABLE: modalidad 
--

CREATE TABLE modalidad(
    id                    SMALLINT        AUTO_INCREMENT,
    nombre                VARCHAR(120)    NOT NULL,
    cantidad_jugadores    SMALLINT        NOT NULL,
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: narrador 
--

CREATE TABLE narrador(
    id            INT             NOT NULL,
    tipo_medio    VARCHAR(60),
    medio         VARCHAR(120)    NOT NULL,
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: pais 
--

CREATE TABLE pais(
    id        INT             AUTO_INCREMENT,
    nombre    VARCHAR(120)    NOT NULL,
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: participa 
--

CREATE TABLE participa(
    jugador_id    INT    NOT NULL,
    evento_id     INT    NOT NULL,
    equipo_id     INT    NOT NULL,
    PRIMARY KEY (jugador_id, evento_id)
)ENGINE=MYISAM
;



-- 
-- TABLE: participante 
--

CREATE TABLE participante(
    id                  INT             AUTO_INCREMENT,
    telefono            VARCHAR(15),
    nombre              VARCHAR(120)    NOT NULL,
    sexo                CHAR(1)         DEFAULT 'M' NOT NULL,
    correo              VARCHAR(120)    NOT NULL,
    nro_identidad       VARCHAR(30)     NOT NULL,
    tipo_identidad      VARCHAR(30)     NOT NULL,
    fecha_nacimiento    DATE            NOT NULL,
    alias               VARCHAR(30),
    comentario          VARCHAR(255),
    ciudad_id           INT             NOT NULL,
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: patrocinador 
--

CREATE TABLE patrocinador(
    id              INT             AUTO_INCREMENT,
    nombre          VARCHAR(120)    NOT NULL,
    organizacion    VARCHAR(255),
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: patrocinador_evento 
--

CREATE TABLE patrocinador_evento(
    id    INT    NOT NULL,
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: ronda 
--

CREATE TABLE ronda(
    evento_id       INT             NOT NULL,
    numero          SMALLINT        NOT NULL,
    inicio          DATETIME,
    cierre          DATETIME,
    cerrada         BIT(1)          DEFAULT FALSE NOT NULL,
    comentario      VARCHAR(255),
    PRIMARY KEY (evento_id, numero)
)ENGINE=MYISAM
;



-- 
-- TABLE: tipo 
--

CREATE TABLE tipo(
    id             SMALLINT        AUTO_INCREMENT,
    nombre         VARCHAR(120)    NOT NULL,
    descripcion    VARCHAR(255),
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: arbitro 
--

ALTER TABLE arbitro ADD CONSTRAINT Refparticipante35 
    FOREIGN KEY (id)
    REFERENCES participante(id)
;


-- 
-- TABLE: boleta 
--

ALTER TABLE boleta ADD CONSTRAINT Refevento26 
    FOREIGN KEY (evento_id)
    REFERENCES evento(id)
;

ALTER TABLE boleta ADD CONSTRAINT Refronda27 
    FOREIGN KEY (evento_id, numero_ronda)
    REFERENCES ronda(evento_id, numero)
;

ALTER TABLE boleta ADD CONSTRAINT Refmesa29 
    FOREIGN KEY (evento_id, numero_mesa)
    REFERENCES mesa(evento_id, numero)
;


-- 
-- TABLE: boleta_equipo 
--

ALTER TABLE boleta_equipo ADD CONSTRAINT Refequipo49 
    FOREIGN KEY (equipo_id)
    REFERENCES equipo(id)
;

ALTER TABLE boleta_equipo ADD CONSTRAINT Refboleta50 
    FOREIGN KEY (evento_id, numero, numero_ronda, numero_mesa)
    REFERENCES boleta(evento_id, numero, numero_ronda, numero_mesa)
;


-- 
-- TABLE: ciudad 
--

ALTER TABLE ciudad ADD CONSTRAINT Refpais4 
    FOREIGN KEY (pais_id)
    REFERENCES pais(id)
;


-- 
-- TABLE: comite_organizador 
--

ALTER TABLE comite_organizador ADD CONSTRAINT Refparticipante37 
    FOREIGN KEY (persona_id)
    REFERENCES participante(id)
;

ALTER TABLE comite_organizador ADD CONSTRAINT Refevento38 
    FOREIGN KEY (evento_id)
    REFERENCES evento(id)
;


-- 
-- TABLE: data 
--

ALTER TABLE data ADD CONSTRAINT Refboleta43 
    FOREIGN KEY (evento_id, numero_boleta, numero_ronda, numero_mesa)
    REFERENCES boleta(evento_id, numero, numero_ronda, numero_mesa)
;

ALTER TABLE data ADD CONSTRAINT Refequipo44 
    FOREIGN KEY (equipo_id)
    REFERENCES equipo(id)
;


-- 
-- TABLE: evento 
--

ALTER TABLE evento ADD CONSTRAINT Refcategoria1 
    FOREIGN KEY (categoria_id)
    REFERENCES categoria(id)
;

ALTER TABLE evento ADD CONSTRAINT Reftipo2 
    FOREIGN KEY (tipo_id)
    REFERENCES tipo(id)
;

ALTER TABLE evento ADD CONSTRAINT Refmodalidad3 
    FOREIGN KEY (modalidad_id)
    REFERENCES modalidad(id)
;

ALTER TABLE evento ADD CONSTRAINT Refciudad5 
    FOREIGN KEY (ciudad_id)
    REFERENCES ciudad(id)
;


-- 
-- TABLE: jugador 
--

ALTER TABLE jugador ADD CONSTRAINT Refparticipante34 
    FOREIGN KEY (id)
    REFERENCES participante(id)
;


-- 
-- TABLE: mesa 
--

ALTER TABLE mesa ADD CONSTRAINT Refevento22 
    FOREIGN KEY (evento_id)
    REFERENCES evento(id)
;


-- 
-- TABLE: narrador 
--

ALTER TABLE narrador ADD CONSTRAINT Refparticipante36 
    FOREIGN KEY (id)
    REFERENCES participante(id)
;


-- 
-- TABLE: participa 
--

ALTER TABLE participa ADD CONSTRAINT Refjugador46 
    FOREIGN KEY (jugador_id)
    REFERENCES jugador(id)
;

ALTER TABLE participa ADD CONSTRAINT Refevento47 
    FOREIGN KEY (evento_id)
    REFERENCES evento(id)
;

ALTER TABLE participa ADD CONSTRAINT Refequipo48 
    FOREIGN KEY (equipo_id)
    REFERENCES equipo(id)
;


-- 
-- TABLE: participante 
--

ALTER TABLE participante ADD CONSTRAINT Refciudad12 
    FOREIGN KEY (ciudad_id)
    REFERENCES ciudad(id)
;


-- 
-- TABLE: patrocinador_evento 
--

ALTER TABLE patrocinador_evento ADD CONSTRAINT Refpatrocinador10 
    FOREIGN KEY (id)
    REFERENCES patrocinador(id)
;

ALTER TABLE patrocinador_evento ADD CONSTRAINT Refevento11 
    FOREIGN KEY (id)
    REFERENCES evento(id)
;


-- 
-- TABLE: ronda 
--

ALTER TABLE ronda ADD CONSTRAINT Refevento21 
    FOREIGN KEY (evento_id)
    REFERENCES evento(id)
;


