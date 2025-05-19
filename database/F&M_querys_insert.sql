/*QUERYS Food and Mood - CRUD*/

--CREATE
INSERT INTO usuario (correo, contrasenia) VALUES 
('katherine@foodmood.com', 'kat123'),
('cliente1@correo.com'   , 'clave123'),
('cliente2@correo.com'   , 'clave456');

INSERT INTO cliente (nombre, apellido, telefono, estado, fk_usuario) VALUES 
('Ana'    , 'Ramírez'  , '1234567890', 'Tabasco'         , 2),
('Luis'   , 'Fernández', '0987654321', 'Ciudad de México', 3),
('Claudia', 'Pérez'    , '1112223333',  'Verazcruz'      , 1);

INSERT INTO servicios (nombre_servicio, precio_servicio) VALUES 
('Cristaleria'   , 1000.00),
('Manteleria'    , 500.00),
('Meseros'       , 2500.00),
('Musica en Vivo', 4000.00),
('Decoracion'    , 2500.00);

INSERT INTO aperitivos (nombre_aperitivo) VALUES 
('Tabla de Quesos'),
('Falafel con salsa de tahini'),
('Pinchos de verduras con hummus'),
('Mini quiches de verduras'),
('Brochetas de Tomate y Mozzarella'),
('Mini tostadas de aguacate y huevo poché');


INSERT INTO entradas (nombre_entrada) VALUES 
('Mini hamburguesas de ternera'),
('Pinchos de filete de ternera con salsa de reducción de vino'),
('Croquetas de pescado con salsa tártara'),
('Mini tartaletas de langostinos con salsa de mantequilla'),
('Crema de langostino con crutones de Baguette'),
('Crema de champiñones con crutones');

INSERT INTO plato_fuerte (nombre_plato_fuerte) VALUES 
('Albóndigas de ternera en salsa de tomate con pasta'),
('Paella de mariscos con arroz y verduras'),
('Lasaña de verduras con queso y salsa de tomate'),
('Filete de ternera a la pimienta con puré de papas'),
('Salmón a la parrilla con ensalada de aguacate y mango'),
('Pollo al horno con trufa y puré de papas'),
('Salmón ahumado con ensalada de aguacate y caviar'),
('Camarones al ajillo con arroz y ensalada de lechuga');

INSERT INTO postres (nombre_postre) VALUES 
('Pastel Integral de Zanahoria'),
('Brownies de chocolate y vainilla adicionados con nueces de castilla'),
('Mousse de Mango'),
('Mousse de Fresa'),
('Chessecake de frutos rojos'),
('Queso Napolitano');

INSERT INTO bebidas (nombre_bebida) VALUES 
('Limonada de fresa'),
('Agua de horchata con pétalos de rosa'),
('Agua mineral con gas'),
('Té helado de frutas'),
('Jugo de naranja fresco'),
('Limonada de arandano'),
('Agua de maracuya');

INSERT INTO metodo_pago (tipo_metodo_pago) VALUES
('Transferencia'),
('Efectivo'),
('Débito'),
('Crédito');

INSERT INTO evento (fecha_evento, lugar_evento, hora_evento, duracion_evento, cantidad_invitados, tipo_evento) VALUES
('2025-04-10', 'Salón Real Eventos'    , '18:00', 5, 100, 'Boda'), 
('2025-05-05', 'Jardín Infantil'       , '12:00', 4, 50 , 'Cumpleaños'),
('2025-06-15', 'Centro de Convenciones', '13:30', 3, 150, 'Conferencia');


INSERT INTO paquete (nombre_paquete, anfitrion, fk_evento, fk_aperitivo, fk_entrada, fk_plato_fuerte,
fk_postre, fk_bebida, fk_metodo_pago) 
VALUES 
('Paquete Personalizado', 'María López'  , 1, 1, 1, 1, 1, 1, 1),
('Paquete Personalizado', 'Laura Sánchez', 2, 2, 2, 2, 2, 2, 2),
('Paquete Personalizado', 'Carlos Méndez', 3, 3, 3, 3, 3, 3, 3);

INSERT INTO paquete_servicio (fk_paquete, fk_servicio, fk_cliente) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 3, 1),
(2, 1, 2),
(2, 2, 2),
(3, 1, 3),
(3, 2, 3),
(3, 3, 3),
(3, 4, 3);

INSERT INTO cotizacion (fk_paquete, fk_cliente, fk_evento, total) VALUES 
(1, 1, 1, 30000.00),
(2, 2, 2, 25000.00),
(3, 3, 3, 40000.00);

INSERT INTO datos_pago (referencia_pago, fk_metodo_pago, estado_pago, fecha_pago, fk_cliente, fk_usuario) VALUES
('PGY8-3K9W-ZX71-JH5R', 2, 'Pendiente', '2025-01-12', 1, 1),
('A29L-7V3Q-MT84-NX2C', 3, 'Pagado'   , '2025-02-25', 2, 2),
('RD6X-1PBZ-KL03-QT7M', 4, 'Pagado'   , '2025-03-26', 3, 3);

INSERT INTO pago (fk_paquete , fk_cotizacion, fk_cliente, fk_datos_pago, fk_total_pago) VALUES
(1, 1, 1, 1, 1),
(2, 2, 2, 2, 2),
(3, 3,3 , 3, 3);

