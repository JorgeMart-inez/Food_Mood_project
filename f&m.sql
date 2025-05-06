/*QUERY BD*/
CREATE DATABASE food_mood;

/*QUERY TABLAS*/

CREATE TABLE usuario(
id_usuario  SERIAL PRIMARY KEY,
correo      VARCHAR(255) UNIQUE NOT NULL,
contrasenia VARCHAR(200) NOT NULL,
rol         VARCHAR(50)  NOT NULL DEFAULT ('usuario')
);

CREATE TABLE cliente(
id_cliente SERIAL PRIMARY KEY,
nombre     VARCHAR(60)  NOT NULL,
apellido   VARCHAR(60)  NOT NULL,
telefono   VARCHAR(10)  NOT NULL,
estado     VARCHAR(40)  NOT NULL,
fk_usuario INTEGER      NOT NULL,
FOREIGN KEY (fk_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE servicios(
id_servicio     SERIAL PRIMARY KEY, 
nombre_servicio VARCHAR(100) NOT NULL,
precio_servicio NUMERIC(10,2)  NOT NULL
);

CREATE TABLE aperitivos(
id_aperitivo     SERIAL PRIMARY KEY,
nombre_aperitivo VARCHAR(255) NOT NULL
);

CREATE TABLE entradas(
id_entrada     SERIAL PRIMARY KEY, 
nombre_entrada VARCHAR(255) NOT NULL
);

CREATE TABLE plato_fuerte(
id_plato_fuerte     SERIAL PRIMARY KEY, 
nombre_plato_fuerte VARCHAR(255) NOT NULL
);

CREATE TABLE postres(
id_postre     SERIAL PRIMARY KEY,
nombre_postre VARCHAR(255) NOT NULL
);

CREATE TABLE bebidas(
id_bebida     SERIAL PRIMARY KEY,
nombre_bebida VARCHAR(255) NOT NULL
);

CREATE TABLE metodo_pago(
id_metodo_pago   SERIAL PRIMARY KEY,
tipo_metodo_pago VARCHAR(130) NOT NULL
);

CREATE TABLE evento(
id_evento          SERIAL PRIMARY KEY,
fecha_evento       DATE         NOT NULL, 
lugar_evento       VARCHAR(255) NOT NULL, 
hora_evento        TIME         NOT NULL, 
duracion_evento    INTEGER      NOT NULL,
cantidad_invitados INTEGER      NOT NULL, 
tipo_evento        VARCHAR(255) NOT NULL 
);

CREATE TABLE paquete(
id_paquete         SERIAL PRIMARY KEY,
nombre_paquete     VARCHAR(255) NOT NULL,
anfitrion          VARCHAR(255) NOT NULL,
fk_evento          INTEGER NOT NULL,
fk_aperitivo       INTEGER NOT NULL, 
fk_entrada         INTEGER NOT NULL, 
fk_plato_fuerte	   INTEGER NOT NULL, 
fk_postre	       INTEGER,
fk_bebida          INTEGER NOT NULL, 
fk_metodo_pago     INTEGER NOT NULL,
FOREIGN KEY (fk_evento)       REFERENCES evento(id_evento),
FOREIGN KEY (fk_aperitivo)    REFERENCES aperitivos(id_aperitivo),
FOREIGN KEY (fk_entrada)      REFERENCES entradas(id_entrada),
FOREIGN KEY (fk_plato_fuerte) REFERENCES plato_fuerte(id_plato_fuerte),
FOREIGN KEY (fk_postre)       REFERENCES postres(id_postre),
FOREIGN KEY (fk_bebida)       REFERENCES bebidas(id_bebida),
FOREIGN KEY (fk_metodo_pago)  REFERENCES metodo_pago(id_metodo_pago)
);

CREATE TABLE paquete_servicio(
fk_paquete  INTEGER NOT NULL,
fk_servicio INTEGER NOT NULL,
fk_cliente  INTEGER NOT NULL,
FOREIGN KEY (fk_paquete)  REFERENCES paquete(id_paquete),
FOREIGN KEY (fk_servicio) REFERENCES servicios(id_servicio),
FOREIGN KEY (fk_cliente)  REFERENCES cliente(id_cliente)
);

CREATE TABLE cotizacion(
id_cotizacion       SERIAL  PRIMARY KEY,
fk_paquete          INTEGER NOT NULL,
fk_cliente          INTEGER NOT NULL,
fk_evento           INTEGER NOT NULL,
total         NUMERIC(7,2)  NOT NULL,
FOREIGN KEY (fk_paquete)          REFERENCES paquete(id_paquete),
FOREIGN KEY (fk_cliente)          REFERENCES cliente(id_cliente),
FOREIGN KEY (fk_evento)           REFERENCES evento(id_evento)
);

/* referencia se obtiene de libreria*/
CREATE TABLE datos_pago(
id_datos_pago   SERIAL PRIMARY KEY, 
referencia_pago VARCHAR(255)  NOT NULL, 
fk_metodo_pago  INTEGER       NOT NULL, 
estado_pago     VARCHAR(255)  NOT NULL DEFAULT 'Pendiente', 
fecha_pago      DATE          NOT NULL, 
fk_cliente      INTEGER       NOT NULL,
fk_usuario      INTEGER       NOT NULL,
FOREIGN KEY (fk_metodo_pago) REFERENCES metodo_pago(id_metodo_pago),
CONSTRAINT  chk_estado_pago  CHECK      (estado_pago IN('Pendiente', 'Pagado', 'Cancelado')),
FOREIGN KEY (fk_cliente)     REFERENCES cliente(id_cliente),
FOREIGN KEY (fk_usuario)     REFERENCES usuario(id_usuario)
);

CREATE TABLE pago(
id_pago         SERIAL PRIMARY KEY,
fk_paquete      INTEGER      NOT NULL, 
fk_cotizacion   INTEGER      NOT NULL, 
fk_cliente      INTEGER      NOT NULL,
fk_datos_pago   INTEGER      NOT NULL,
FOREIGN KEY (fk_paquete)    REFERENCES paquete(id_paquete),
FOREIGN KEY (fk_cotizacion) REFERENCES cotizacion(id_cotizacion),
FOREIGN KEY (fk_cliente)    REFERENCES cliente(id_cliente)
);


