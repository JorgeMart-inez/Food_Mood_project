/*QUERYS Food and Mood - CRUD*/

--READ--

--Tabla usuario
SELECT * from usuario;

--Tabla cliente
SELECT * FROM cliente;

--Tabla servicios
SELECT * FROM servicios;

--Tabla aperitivos
SELECT * FROM aperitivos;

--Tabla entradas
SELECT * FROM entradas;

--Tabla plato_fuerte
SELECT * FROM plato_fuerte;

--Tabla postres
SELECT * FROM postres;

--Tabla bebidas
SELECT * FROM bebidas;

--Tabla metodo_pago
SELECT * FROM metodo_pago;

--Tabla evento
SELECT * FROM evento;

--Tabla paquete
SELECT * FROM paquete;

--Tabla paquete_servicio
SELECT * FROM paquete_servicio;

--Tabla cotizacion
SELECT * FROM cotizacion;

--Tabla datos_pago
SELECT * FROM datos_pago;

--Tabla pago
SELECT * FROM pago;

--Tabla paquete
SELECT 
	p.id_paquete,
	p.nombre_paquete,
	p.anfitrion,
	e.fecha_evento,
	e.hora_evento,
	e.lugar_evento,
  	e.duracion_evento,
	e.cantidad_invitados,
  	e.tipo_evento,
	ap.nombre_aperitivo    AS nombre_aperitivo,
	en.nombre_entrada      AS nombre_entrada,
	pf.nombre_plato_fuerte AS nombre_plato_fuerte,
	po.nombre_postre       AS nombre_postre,
	b.nombre_bebida        AS nombre_bebida,
	mp.tipo_metodo_pago    AS tipo_metodo_pago
	FROM paquete p
	JOIN evento e          ON p.fk_evento       = e.id_evento
	JOIN aperitivos ap     ON p.fk_aperitivo    = ap.id_aperitivo
	JOIN entradas en       ON p.fk_entrada      = en.id_entrada
	JOIN plato_fuerte pf   ON p.fk_plato_fuerte = pf.id_plato_fuerte
	JOIN postres po        ON p.fk_postre       = po.id_postre
	JOIN bebidas b         ON p.fk_bebida       = b.id_bebida
	JOIN metodo_pago mp    ON p.fk_metodo_pago  = mp.id_metodo_pago
WHERE p.id_paquete = 1
    GROUP BY
		p.id_paquete,
		p.nombre_paquete,
		p.anfitrion,
		e.fecha_evento,
		e.hora_evento,
		e.lugar_evento,
	  	e.duracion_evento,
		e.cantidad_invitados,
	  	e.tipo_evento,
		ap.nombre_aperitivo,
		en.nombre_entrada,
		pf.nombre_plato_fuerte,
		po.nombre_postre,
		b.nombre_bebida,
		mp.tipo_metodo_pago;

--Tabla cotizacion
SELECT 
 c.id_cotizacion,
 c.total,
 cl.nombre,
 cl.apellido,
 p.nombre_paquete,
 p.anfitrion,
 e.tipo_evento			AS tipo_evento,
 e.fecha_evento		    AS fecha_evento, 
 e.lugar_evento         AS lugar_evento, 
 e.hora_evento          AS hora_evento,  
 e.duracion_evento      AS duracion_evento, 
 e.cantidad_invitados   AS cantidad_invitados,
 ap.nombre_aperitivo    AS nombre_aperitivo,
 en.nombre_entrada      AS nombre_entrada,
 pf.nombre_plato_fuerte AS nombre_plato_fuerte,
 po.nombre_postre       AS nombre_postre,
 b.nombre_bebida        AS nombre_bebida,
 mp.tipo_metodo_pago    AS tipo_metodo_pago
 FROM cotizacion c
    JOIN paquete p         ON c.fk_paquete = p.id_paquete
    JOIN cliente cl        ON c.fk_cliente = cl.id_cliente
    JOIN evento e          ON c.fk_evento  = e.id_evento
    JOIN aperitivos ap     ON p.fk_aperitivo    = ap.id_aperitivo
	JOIN entradas en       ON p.fk_entrada      = en.id_entrada
	JOIN plato_fuerte pf   ON p.fk_plato_fuerte = pf.id_plato_fuerte
	JOIN postres po        ON p.fk_postre       = po.id_postre
	JOIN bebidas b         ON p.fk_bebida       = b.id_bebida
	JOIN metodo_pago mp    ON p.fk_metodo_pago  = mp.id_metodo_pago;
--	WHERE c.id_cotizacion = 1
 

--Tabla pago Obtener cliente: Nombre, correo. paquete: numero, 
