SET @DESCRIPCION = 'Integer at fermentum velit. Curabitur ultricies mi in massa elementum, imperdiet condimentum ante tempus. Duis vehicula eu lorem in vestibulum. Suspendisse potenti. Sed bibendum vestibulum dui eu aliquam. Pellentesque ut dolor non sem luctus suscipit. Cras sed metus ornare, pretium magna eget, aliquam mauris. Curabitur rutrum aliquet placerat. Nunc hendrerit elit risus, convallis lobortis ipsum sodales sit amet.
Sed bibendum vestibulum dui eu aliquam. Pellentesque ut dolor non sem luctus suscipit. Cras sed metus ornare, pretium magna eget, aliquam mauris. Curabitur rutrum aliquet placerat. Cras sed metus ornare, pretium magna eget, aliquam mauris. Curabitur rutrum aliquet placerat. Nunc hendrerit elit risus, convallis lobortis ipsum sodales sit amet.
Duis vehicula eu lorem in vestibulum. Suspendisse potenti. Duis vehicula eu lorem in vestibulum. Suspendisse potenti. Duis vehicula eu lorem in vestibulum. Suspendisse potenti. Duis vehicula eu lorem in vestibulum.';

INSERT INTO eventos(id_evento, nombre, organizador, fecha, hora, lugar, url, descripcion, url_portada)
VALUES
	(1, 'El espacio',		'Asociación de fotografía del espacio',		'2021-06-23', '23:30:00', 'Mirador de San Miguel Alto', 'https://www.elespacio.com', 		@DESCRIPCION, '/img/stars.jpg'),
	(2, 'Los animales', 	'Asociación de fotografía de animales', 	'2021-06-30', '17:15:00', 'Parque de los animales', 	'https://www.losanimales.com', 		@DESCRIPCION, '/img/animals.jpg'),
	(3, 'Los retratos', 	'Asociación de fotografía de retratos', 	'2021-07-01', '12:30:00', 'Parque de los retratos', 	'https://www.losretratos.com', 		@DESCRIPCION, '/img/portrait.jpg'),
	(4, 'Los monumentos', 	'Asociación de fotografía de monumentos', 	'2021-07-01', '19:00:00', 'Parque de los monumentos', 	'https://www.losmonumentos.com', 	@DESCRIPCION, '/img/alhambra.jpg'),
	(5, 'Los mares', 		'Asociación de fotografía de mares', 		'2021-07-04', '06:30:00', 'Parque de los mares', 		'https://www.losmares.com', 		@DESCRIPCION, '/img/palms.jpg'),
	(6, 'Los lagos', 		'Asociación de fotografía de lagos', 		'2021-07-08', '09:45:00', 'Parque de los lagos', 		'https://www.loslagos.com', 		@DESCRIPCION, '/img/landscape.jpg'),
	(7, 'El frío', 		'Asociación de fotografría del frío', 		'2021-07-09', '21:00:00', 'Parque del frío', 			'https://www.elfrio.com', 			@DESCRIPCION, '/img/landscape.jpg'),
	(8, 'Los relojes', 	'Asociación de fotografía de relojes', 		'2021-08-01', '18:15:00', 'Parque de los relojes', 		'https://www.losrelojes.com', 		@DESCRIPCION, '/img/clock.jpg'),
	(9, 'Los ojos', 		'Asociación de fotografía de ojos', 		'2021-08-07', '12:45:00', 'Parque de los ojos', 		'https://www.losojos.com', 			@DESCRIPCION, '/img/eyes.jpg');

