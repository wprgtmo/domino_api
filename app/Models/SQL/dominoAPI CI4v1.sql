--
-- ER/Studio 8.0 SQL Code Generation
-- Company :      CASA
-- Project :      dominoAPI CI4.DM1
-- Author :       Dayron
--
-- Date Created : Friday, September 10, 2021 19:42:34
-- Target DBMS : MySQL 5.x
--

-- 
-- TABLE: boleta 
--

CREATE TABLE boleta(
    id                INT         AUTO_INCREMENT,
    evento_id         INT         NOT NULL,
    ronda_id          INT         NOT NULL,
    mesa_id           INT         NOT NULL,
    es_valida         BIT(1)      DEFAULT TRUE NOT NULL,
    fecha_registro    CHAR(10),
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: boleta_pareja 
--

CREATE TABLE boleta_pareja(
    id           INT         AUTO_INCREMENT,
    boleta_id    INT         NOT NULL,
    pareja_id    INT         NOT NULL,
    salidor      BIT(1)      DEFAULT FALSE NOT NULL,
    tantos       INT         NOT NULL,
    resultado    INT         DEFAULT 0 NOT NULL,
    ganador      BIT(1)      DEFAULT FALSE NOT NULL,
    inicio       DATETIME    NOT NULL,
    duracion     DATETIME,
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
-- TABLE: data 
--

CREATE TABLE data(
    id                 INT         AUTO_INCREMENT,
    numero             SMALLINT    NOT NULL,
    boleta_id          INT         NOT NULL,
    pareja_ganadora    INT         NOT NULL,
    puntos             INT         NOT NULL,
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: evento 
--

CREATE TABLE evento(
    id              INT             AUTO_INCREMENT,
    ciudad_id       INT             NOT NULL,
    nombre          VARCHAR(120)    NOT NULL,
    comentario      VARCHAR(255),
    cerrado         BIT(1)          DEFAULT FALSE NOT NULL,
    fecha_inicio    DATETIME,
    fecha_cierre    DATETIME,
    creado          DATETIME        NOT NULL,
    actualizado     DATETIME        NOT NULL,
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: jugador 
--

CREATE TABLE jugador(
    id                  INT             AUTO_INCREMENT,
    telefono            VARCHAR(15),
    nombre              VARCHAR(120)    NOT NULL,
    sexo                CHAR(1)         DEFAULT 'M' NOT NULL,
    correo              VARCHAR(120)    NOT NULL,
    nro_identidad       VARCHAR(30)     NOT NULL,
    fecha_nacimiento    DATE            NOT NULL,
    alias               VARCHAR(30),
    ocupacion           VARCHAR(120),
    comentario          VARCHAR(255),
    nivel               VARCHAR(30)     NOT NULL,
    elo                 INT             DEFAULT 0 NOT NULL,
    ranking             CHAR(2),
    tipo                CHAR(1),
    ciudad_id           INT             NOT NULL,
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: mesa 
--

CREATE TABLE mesa(
    id           INT         AUTO_INCREMENT,
    evento_id    INT         NOT NULL,
    numero       SMALLINT    NOT NULL,
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
-- TABLE: pareja 
--

CREATE TABLE pareja(
    id             INT            AUTO_INCREMENT,
    nombre         VARCHAR(60)    NOT NULL,
    evento_id      INT            NOT NULL,
    jugador1_id    INT            NOT NULL,
    jugador2_id    INT            NOT NULL,
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- TABLE: ronda 
--

CREATE TABLE ronda(
    id            INT             AUTO_INCREMENT,
    evento_id     INT             NOT NULL,
    numero        SMALLINT        NOT NULL,
    inicio        DATETIME,
    cierre        DATETIME,
    dia           SMALLINT        NOT NULL,
    cerrada       BIT(1)          DEFAULT FALSE NOT NULL,
    comentario    VARCHAR(255),
    PRIMARY KEY (id)
)ENGINE=MYISAM
;



-- 
-- INDEX: PK_ALT13 
--

CREATE UNIQUE INDEX PK_ALT13 ON boleta(evento_id, mesa_id, ronda_id)
;
-- 
-- INDEX: Ref157 
--

CREATE INDEX Ref157 ON boleta(evento_id)
;
-- 
-- INDEX: Ref1158 
--

CREATE INDEX Ref1158 ON boleta(ronda_id)
;
-- 
-- INDEX: Ref1059 
--

CREATE INDEX Ref1059 ON boleta(mesa_id)
;
-- 
-- INDEX: Ref1360 
--

CREATE INDEX Ref1360 ON boleta_pareja(boleta_id)
;
-- 
-- INDEX: Ref1761 
--

CREATE INDEX Ref1761 ON boleta_pareja(pareja_id)
;
-- 
-- INDEX: Ref24 
--

CREATE INDEX Ref24 ON ciudad(pais_id)
;
-- 
-- INDEX: PK_ALT14 
--

CREATE UNIQUE INDEX PK_ALT14 ON data(boleta_id, numero)
;
-- 
-- INDEX: Ref1362 
--

CREATE INDEX Ref1362 ON data(boleta_id)
;
-- 
-- INDEX: Ref1763 
--

CREATE INDEX Ref1763 ON data(pareja_ganadora)
;
-- 
-- INDEX: Ref35 
--

CREATE INDEX Ref35 ON evento(ciudad_id)
;
-- 
-- INDEX: Ref312 
--

CREATE INDEX Ref312 ON jugador(ciudad_id)
;
-- 
-- INDEX: K_ALT10 
--

CREATE UNIQUE INDEX K_ALT10 ON mesa(evento_id, numero)
;
-- 
-- INDEX: Ref153 
--

CREATE INDEX Ref153 ON mesa(evento_id)
;
-- 
-- INDEX: Ref167 
--

CREATE INDEX Ref167 ON pareja(evento_id)
;
-- 
-- INDEX: Ref1270 
--

CREATE INDEX Ref1270 ON pareja(jugador1_id)
;
-- 
-- INDEX: Ref1271 
--

CREATE INDEX Ref1271 ON pareja(jugador2_id)
;
-- 
-- INDEX: PK_ALT11 
--

CREATE UNIQUE INDEX PK_ALT11 ON ronda(evento_id, numero)
;
-- 
-- INDEX: Ref151 
--

CREATE INDEX Ref151 ON ronda(evento_id)
;
-- 
-- TABLE: boleta 
--

ALTER TABLE boleta ADD CONSTRAINT Refevento57 
    FOREIGN KEY (evento_id)
    REFERENCES evento(id)
;

ALTER TABLE boleta ADD CONSTRAINT Refronda58 
    FOREIGN KEY (ronda_id)
    REFERENCES ronda(id)
;

ALTER TABLE boleta ADD CONSTRAINT Refmesa59 
    FOREIGN KEY (mesa_id)
    REFERENCES mesa(id)
;


-- 
-- TABLE: boleta_pareja 
--

ALTER TABLE boleta_pareja ADD CONSTRAINT Refboleta60 
    FOREIGN KEY (boleta_id)
    REFERENCES boleta(id)
;

ALTER TABLE boleta_pareja ADD CONSTRAINT Refpareja61 
    FOREIGN KEY (pareja_id)
    REFERENCES pareja(id)
;


-- 
-- TABLE: ciudad 
--

ALTER TABLE ciudad ADD CONSTRAINT Refpais4 
    FOREIGN KEY (pais_id)
    REFERENCES pais(id)
;


-- 
-- TABLE: data 
--

ALTER TABLE data ADD CONSTRAINT Refboleta62 
    FOREIGN KEY (boleta_id)
    REFERENCES boleta(id)
;

ALTER TABLE data ADD CONSTRAINT Refpareja63 
    FOREIGN KEY (pareja_ganadora)
    REFERENCES pareja(id)
;


-- 
-- TABLE: evento 
--

ALTER TABLE evento ADD CONSTRAINT Refciudad5 
    FOREIGN KEY (ciudad_id)
    REFERENCES ciudad(id)
;


-- 
-- TABLE: jugador 
--

ALTER TABLE jugador ADD CONSTRAINT Refciudad12 
    FOREIGN KEY (ciudad_id)
    REFERENCES ciudad(id)
;


-- 
-- TABLE: mesa 
--

ALTER TABLE mesa ADD CONSTRAINT Refevento53 
    FOREIGN KEY (evento_id)
    REFERENCES evento(id)
;


-- 
-- TABLE: pareja 
--

ALTER TABLE pareja ADD CONSTRAINT Refevento67 
    FOREIGN KEY (evento_id)
    REFERENCES evento(id)
;

ALTER TABLE pareja ADD CONSTRAINT Refjugador70 
    FOREIGN KEY (jugador1_id)
    REFERENCES jugador(id)
;

ALTER TABLE pareja ADD CONSTRAINT Refjugador71 
    FOREIGN KEY (jugador2_id)
    REFERENCES jugador(id)
;


-- 
-- TABLE: ronda 
--

ALTER TABLE ronda ADD CONSTRAINT Refevento51 
    FOREIGN KEY (evento_id)
    REFERENCES evento(id)
;


