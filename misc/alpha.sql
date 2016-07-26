/*Removes existing database and initializes a new set */

/*Removes table*/
DROP TABLE package;
DROP TABLE container;
DROP TABLE cluster;

/*Creates table for address and initializes content*/
CREATE TABLE cluster(
	id serial primary key not null ,
	name varchar not null,	
	length real not null,
	width real not null,
	height real not null default 1.6
);


INSERT INTO cluster values(default, 'BWE',2.4,1.2);			
INSERT INTO cluster values(default, 'Central 1', 6, 2.4);	
INSERT INTO cluster values(default, 'Central 2', 6, 2.4);	
INSERT INTO cluster values(default, 'Domestic', 2.4, 1.2);	
INSERT INTO cluster values(default, 'East 1', 7.2, 2.4);
INSERT INTO cluster values(default, 'East 2', 7.2, 2.4);
INSERT INTO cluster values(default, 'East 3', 7.2, 1.2);
INSERT INTO cluster values(default, 'East 4', 7.2, 1.2);
INSERT INTO cluster values(default, 'North 1', 7.2, 1.2);
INSERT INTO cluster values(default, 'North 2', 7.2, 1.2);
INSERT INTO cluster values(default, 'RSO', 6, 1.2);
INSERT INTO cluster values(default, 'South 1', 7.2, 1.2);	
INSERT INTO cluster values(default, 'South 2', 7.2, 1.2);	
INSERT INTO cluster values(default, 'West 1', 3.6, 1.2);
INSERT INTO cluster values(default, 'West 2', 3.6, 1.2);	

/*creates table for container*/
CREATE TABLE container(
	id serial primary key not null,
	cluster int not null references cluster (id) on delete cascade on update cascade,
	city varchar not null,
	keywords varchar not null,
	is_serviceable boolean default true
);

INSERT INTO container values(default, 1, 'Quezon','Agno, Banaue');
INSERT INTO container values(default, 2, 'Makati','San Antonio Village, Makati');
INSERT INTO container values(default, 2, 'Makati','Pasong Tamo, Makati');
INSERT INTO container values(default, 2, 'Makati','J.P. Rizal Avenue, Makati City');
INSERT INTO container values(default, 2, 'Makati','La Paz, Makati City');
INSERT INTO container values(default, 2, 'Makati','Cardona Street, Makati City');
INSERT INTO container values(default, 2, 'Makati','Ayala Avenue, Makati City');
INSERT INTO container values(default, 2, 'Mandaluyong','Plainview, Mandaluyong City');
INSERT INTO container values(default, 2, 'Makati','Legazpi Village, Makati');
INSERT INTO container values(default, 2, 'Makati','San Lorenzo, Makati');
INSERT INTO container values(default, 2, 'Makati','Bel-Air, Makati');
INSERT INTO container values(default, 2, 'Makati','Guadalupe Viejo, Makati');
INSERT INTO container values(default, 2, 'Makati','Guadalupe Nuevo, Makati');
INSERT INTO container values(default, 2, 'Makati','Poblacion, Makati');
INSERT INTO container values(default, 2, 'Makati','Pembo, Makati');
INSERT INTO container values(default, 2, 'Makati','Cembo, Makati');
INSERT INTO container values(default, 2, 'Makati','Rembo, Makati');
INSERT INTO container values(default, 2, 'Makati','Chino Roses Avenue, Makati');
INSERT INTO container values(default, 2, 'Makati','Pio del Pilar, Makati');
INSERT INTO container values(default, 3, 'Manila','Malate, Manila');
INSERT INTO container values(default, 3, 'Manila','Pandacan, Manila');
INSERT INTO container values(default, 3, 'Manila','Santa Ana, Manila');
INSERT INTO container values(default, 3, 'Makati','Palanan, Makati City');
INSERT INTO container values(default, 3, 'Manila','San Andres Bukid, Manila');
INSERT INTO container values(default, 3, 'Manila','Ermita, Manila');
INSERT INTO container values(default, 3, 'Manila','Paco, Manila');
INSERT INTO container values(default, 3, 'Makati','Bangkal, Makati');
INSERT INTO container values(default, 3, 'Makati','San Isidro, Makati');
INSERT INTO container values(default, 4, 'Pasay' ,'Terminal 4, Pasay');
INSERT INTO container values(default, 5, 'Mandaluyong' ,'Hagdang Bato Libis, Mandaluyong');
INSERT INTO container values(default, 5, 'Mandaluyong', 'Pleasant View, Mandaluyong');
INSERT INTO container values(default, 5,' Mandaluyong', 'Additional Hills, Mandaluyong');
INSERT INTO container values(default, 5, 'Quezon', 'E. Rodriguez, Quezon City');
INSERT INTO container values(default, 5, 'Quezon', 'South Triangle, Diliman, Quezon City');
INSERT INTO container values(default, 5, 'Quezon', 'Obrero, Diliman, Quezon City');
INSERT INTO container values(default, 5, 'Quezon', 'Little Baguio, San Juan City');
INSERT INTO container values(default, 5, 'Quezon', 'Aurora Boulevard, Quezon City');
INSERT INTO container values(default, 5, 'Quezon', 'New Manila, Quezon City');
INSERT INTO container values(default, 5, 'Quezon', 'Cubao, Quezon City');
INSERT INTO container values(default, 5, 'Quezon', 'Camp Crame, Cubao, Quezon City');
INSERT INTO container values(default, 5, 'Mandaluyong', 'Wack wack Greenhills, Mandaluyong');
INSERT INTO container values(default, 6, 'Quezon', 'G. Roxas Street, Quezon City');
INSERT INTO container values(default, 6, 'Quezon', 'N.S. Amoranto Sr. Street, Quezon City');
INSERT INTO container values(default, 6, 'Quezon','Grace Village, Quezon City');
INSERT INTO container values(default, 6, 'Quezon', 'Balingasa, Quezon City');
INSERT INTO container values(default, 6, 'Quezon','Masambong, Quezon City');
INSERT INTO container values(default, 6, 'Quezon','Talayan, Quezon City');
INSERT INTO container values(default, 6, 'Quezon','Katipunan, Quezon City');
INSERT INTO container values(default, 6, 'Quezon','Heroes Hills Subdivision, Roosevelt Avenue, Quezon City');
INSERT INTO container values(default, 6, 'Quezon','Tatalon, Quezon City');
INSERT INTO container values(default, 6, 'Manila','Santa Mesa, Manila');
INSERT INTO container values(default, 6, 'Manila','Santa Mesa, Manila');
INSERT INTO container values(default, 6, 'Manila','Sampaloc, Manila');
INSERT INTO container values(default, 6, 'Pasig','Ortigas Center, Pasig City');
INSERT INTO container values(default, 6, 'Pasig','Ortigas Center, Pasig City');
INSERT INTO container values(default, 6, 'Pasig','Kapitolyo, Pasig City');
INSERT INTO container values(default, 7, 'Marikina','Marikina City');
INSERT INTO container values(default, 7, 'Rizal','San Mateo, Rizal');
INSERT INTO container values(default, 7, 'Rizal','Cainta, Rizal');
INSERT INTO container values(default, 7, 'Rizal','Antipolo, Rizal');
INSERT INTO container values(default, 7, 'Rizal','Taytay, Rizal');
INSERT INTO container values(default, 7, 'Pasig','Pasig City');
INSERT INTO container values(default, 7, 'Quezon','Libis, Quezon City');
INSERT INTO container values(default, 7, 'Pasig','Santolan, Pasig City');
INSERT INTO container values(default, 7, 'Pasig','Ugong, Pasig');
INSERT INTO container values(default, 8, 'Quezon','Congressional Avenue, Quezon City');
INSERT INTO container values(default, 8, 'Quezon','Tandang Sora, Quezon City');
INSERT INTO container values(default, 8, 'Quezon','Culiat, Quezon City');
INSERT INTO container values(default, 8, 'Quezon','Araneta Center, Cubao, Quezon City');
INSERT INTO container values(default, 8, 'Quezon','P. Tuazon, Cubao, Quezon City');
INSERT INTO container values(default, 8, 'Quezon','Project 2, Quezon City');
INSERT INTO container values(default, 8, 'Quezon','Batasan Hills, Quezon City');
INSERT INTO container values(default, 8, 'Quezon','Commonwealth, Quezon City');
INSERT INTO container values(default, 9, 'Valenzuela','Malanday, Valenzuela City');
INSERT INTO container values(default, 9, 'Valenzuela','Gen. T. de Leon, Valenzuela City');
INSERT INTO container values(default, 9, 'Valenzuela','Karuhatan, Valenzuela City');
INSERT INTO container values(default, 9, 'Quezon','Novaliches, Quezon City');
INSERT INTO container values(default, 9, 'Caloocan','Northern Caloocan');
INSERT INTO container values(default, 9, 'Malabon','Portero, Malabon City');
INSERT INTO container values(default, 9, 'Caloocan','Grace Park, Caloocan');
INSERT INTO container values(default, 10, 'Caloocan','Bagumbong, Caloocan City');
INSERT INTO container values(default, 10, 'Malabon','Maysilo, Malabon City');
INSERT INTO container values(default, 10, 'Malabon','Panghulo, Malabon');
INSERT INTO container values(default, 10, 'Malabon','Tonsuya, Malabon');
INSERT INTO container values(default, 10, 'Malabon','San Agustin, Malabon');
INSERT INTO container values(default, 10, 'Malabon','Flores, Malabon');
INSERT INTO container values(default, 10, 'Malabon','Ibaba, Malabon');
INSERT INTO container values(default, 10, 'Navotas','Navotas City');
INSERT INTO container values(default, 10, 'Manila','Tondo, Manila');
INSERT INTO container values(default, 10, 'Caloocan','Southern Caloocan');
INSERT INTO container values(default, 10, 'Manila','Binondo, Manila');
INSERT INTO container values(default, 10, 'Manila','Santa Cruz, Manila');
INSERT INTO container values(default, 11, 'Manila','Soler Street, Binondo, Manila');
INSERT INTO container values(default, 11, 'Manila','Juan Luna Street, Binondo, Manila');
INSERT INTO container values(default, 11, 'Manila','Quiapo, Manila');
INSERT INTO container values(default, 11, 'Paranaque','Baclaran, Paranaque');
INSERT INTO container values(default, 11, 'Pasay','Park Avenue, Pasay');
INSERT INTO container values(default, 11, 'Manila','856 Binondo, Manila');
INSERT INTO container values(default, 11, 'Pasay','Russel Avenue, Pasay');
INSERT INTO container values(default, 11, 'Manila','Masangkay Street, Manila');
INSERT INTO container values(default, 11, 'Manila','Benavides Street, Manila');
INSERT INTO container values(default, 11, 'Manila','Tutuban Cluster Mall, Tondo, Manila');
INSERT INTO container values(default, 11, 'Manila','Dagupan Street, Tondo, Manila');
INSERT INTO container values(default, 11, 'Manila','Bambang Street, Santa Cruz, Manila');
INSERT INTO container values(default, 11, 'Manila','Remigio Street, Santa Cruz, Manila');
INSERT INTO container values(default, 11, 'Manila','Rizal Avenue, Manila');
INSERT INTO container values(default, 11, 'Manila','Alvarez Street, Santa Cruz, Manila');
INSERT INTO container values(default, 11, 'Manila','Quricada Street, Santa Cruz, Manila');
INSERT INTO container values(default, 11, 'Manila','Divisoria Market, Recto Avenue, Manila');
INSERT INTO container values(default, 11, 'Marikina','Santa Elena, Marikina City');
INSERT INTO container values(default, 11, 'Taguig','FTI, Taguig');
INSERT INTO container values(default, 12, 'Paranaque','Barangay Merville, Paranaque');
INSERT INTO container values(default, 12, 'Paranaque','Sun Valley, Paranaque City');
INSERT INTO container values(default, 12, 'Taguig','Bagumbayan, Taguig City');
INSERT INTO container values(default, 12, 'Taguig','Tanyag, Taguig City');
INSERT INTO container values(default, 12, 'Taguig','Lower Bicutan, Taguig City');
INSERT INTO container values(default, 12, 'Las Pinas','Pulang Lupa Uno, Las Pinas');
INSERT INTO container values(default, 12, 'Las Pinas','Pulang Lupa Dos, Las Pinas');
INSERT INTO container values(default, 12, 'Muntinlupa','Muntinlupa City');
INSERT INTO container values(default, 12, 'Las Pinas','Zapote, Las Pinas');
INSERT INTO container values(default, 12, 'Taguig','Fort Bonifacio, Taguig City');
INSERT INTO container values(default, 12, 'Manila','Pateros, Manila');
INSERT INTO container values(default, 13, 'Pasay','Andrews Avenue, Pasay City');
INSERT INTO container values(default, 13, 'Paranaque','Macapagal Avenue, Paranaque City');
INSERT INTO container values(default, 13, 'Tambo','Tambo, Paranaque');
INSERT INTO container values(default, 13, 'Manila','Roxas Boulevard');
INSERT INTO container values(default, 14, 'Manila','Quiapo, Manila');
INSERT INTO container values(default, 14, 'Manila','Recto Avenue, Manila');
INSERT INTO container values(default, 15, 'Manila','Intramuros, Manila');
INSERT INTO container values(default, 15, 'Manila','Port Area, Manila');
INSERT INTO container values(default, 15, 'Manila','San Miguel, Manila');

/*creates table for package*/
CREATE TABLE package(
	id serial primary key not null,
	container int not null references container (id) on delete cascade on update cascade,
	length real not null,
	width real not null,
	height real not null,
	weight real not null,
	x1 real not null,
	x2 real not null,
	y1 real not null,
	y2 real not null,
	z1 real not null,
	z2 real not null,
	orientation varchar not null,
	arrival_date timestamp default now(),
	is_fragile boolean default false
);

/*INSERT INTO package values(default, 1, 1,2, 1,50,0,0,0,now(),default);*/

/*
CREATE TABLE corner(
	id serial primary key not null,
	cluster int not null references cluster (id) on delete cascade on update cascade,
	x real not null,
	y real not null,
	z real not null
);
*/
