SET @DESCRIPCION = 'Integer at fermentum velit. Curabitur ultricies mi in massa elementum, imperdiet condimentum ante tempus. Duis vehicula eu lorem in vestibulum. Suspendisse potenti. Sed bibendum vestibulum dui eu aliquam. Pellentesque ut dolor non sem luctus suscipit. Cras sed metus ornare, pretium magna eget, aliquam mauris. Curabitur rutrum aliquet placerat. Nunc hendrerit elit risus, convallis lobortis ipsum sodales sit amet.
Sed bibendum vestibulum dui eu aliquam. Pellentesque ut dolor non sem luctus suscipit. Cras sed metus ornare, pretium magna eget, aliquam mauris. Curabitur rutrum aliquet placerat. Cras sed metus ornare, pretium magna eget, aliquam mauris. Curabitur rutrum aliquet placerat. Nunc hendrerit elit risus, convallis lobortis ipsum sodales sit amet.
Duis vehicula eu lorem in vestibulum. Suspendisse potenti. Duis vehicula eu lorem in vestibulum. Suspendisse potenti. Duis vehicula eu lorem in vestibulum. Suspendisse potenti. Duis vehicula eu lorem in vestibulum.';

INSERT INTO eventos(nombre, organizador, fecha, hora, lugar, url, descripcion, url_portada)
VALUES
	('El espacio',		'Asociación de fotografía del espacio',		'2021-06-23', '23:30:00', 'Mirador de San Miguel Alto', 'https://www.elespacio.com', 		@DESCRIPCION, '/img/stars.jpg'),
	('Los animales', 	'Asociación de fotografía de animales', 	'2021-06-30', '17:15:00', 'Parque de los animales', 	'https://www.losanimales.com', 		'descripcion', '/img/animals.jpg'),
	('Los retratos', 	'Asociación de fotografía de retratos', 	'2021-07-01', '12:30:00', 'Parque de los retratos', 	'https://www.losretratos.com', 		'descripcion', '/img/portrait.jpg'),
	('Los monumentos', 	'Asociación de fotografía de monumentos', 	'2021-07-01', '19:00:00', 'Parque de los monumentos', 	'https://www.losmonumentos.com', 	'descripcion', '/img/alhambra.jpg'),
	('Los mares', 		'Asociación de fotografía de mares', 		'2021-07-04', '06:30:00', 'Parque de los mares', 		'https://www.losmares.com', 		'descripcion', '/img/palms.jpg'),
	('Los lagos', 		'Asociación de fotografía de lagos', 		'2021-07-08', '09:45:00', 'Parque de los lagos', 		'https://www.loslagos.com', 		'descripcion', '/img/landscape.jpg'),
	('El frío', 		'Asociación de fotografría del frío', 		'2021-07-09', '21:00:00', 'Parque del frío', 			'https://www.elfrio.com', 			'descripcion', '/img/landscape.jpg'),
	('Los relojes', 	'Asociación de fotografía de relojes', 		'2021-08-01', '18:15:00', 'Parque de los relojes', 		'https://www.losrelojes.com', 		'descripcion', '/img/clock.jpg'),
	('Los ojos', 		'Asociación de fotografía de ojos', 		'2021-08-07', '12:45:00', 'Parque de los ojos', 		'https://www.losojos.com', 			'descripcion', '/img/eyes.jpg');

