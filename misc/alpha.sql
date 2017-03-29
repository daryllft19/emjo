/*Removes existing database and initializes a new set */

/*Removes table*/
DROP TABLE package;
DROP TABLE address;
DROP TABLE cluster;

/*Creates table for address and initializes content*/
CREATE TABLE cluster(
	id serial primary key not null ,
	name varchar not null,	
	length real not null,
	width real not null,
	height real not null default 1.6
);


INSERT INTO cluster values(default, 'East 1', 720, 240, 120);
INSERT INTO cluster values(default, 'East 2', 720, 240, 120);
INSERT INTO cluster values(default, 'East 3', 720, 120, 120);
INSERT INTO cluster values(default, 'East 4', 720, 120, 120);
INSERT INTO cluster values(default, 'North 1', 720, 120, 120);
INSERT INTO cluster values(default, 'North 2', 720, 120, 120);
INSERT INTO cluster values(default, 'Central 1', 600, 240, 120);	
INSERT INTO cluster values(default, 'Central 2', 600, 240, 120);	
INSERT INTO cluster values(default, 'West 1', 360, 120, 120);
INSERT INTO cluster values(default, 'West 2', 360, 120, 120);	
INSERT INTO cluster values(default, 'South 1', 720, 120, 120);	
INSERT INTO cluster values(default, 'South 2', 720, 120, 120);	
INSERT INTO cluster values(default, 'TEST-CLUSTER',600,240, 120);
-- INSERT INTO cluster values(default, 'South 2', 7.2, 120, 120);	
-- INSERT INTO cluster values(default, 'BWE',240,120, 120);			
-- INSERT INTO cluster values(default, 'Domestic', 240, 120, 120);	
-- INSERT INTO cluster values(default, 'RSO', 6, 120, 120);

/*creates table for address*/
CREATE TABLE address(
	id serial primary key not null,
	cluster int not null references cluster (id) on delete cascade on update cascade,
	province varchar default 'Metro Manila',
	city varchar default '',
	barangay varchar default '',
	district varchar default '',
	area varchar default '',
	avenue varchar default '',
	street varchar default '',
	is_serviceable boolean default true
);

INSERT INTO address values(default, 13, 'TEST PROVINCE','TEST CITY','TEST barangay, street', 'TEST DISTRICT', 'TEST AREA', 'TEST AVENUE', 'TEST STREET');
--CLUSTER EAST 1 -> 1
INSERT INTO address (cluster, city, barangay) values(1, 'Quezon', 'South Triangle');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','West Triangle');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Project 7');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Phil-Am');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Bungad');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Katipunan');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Veterans Village');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Paltok');
INSERT INTO address (cluster, city, district) values(1,'Quezon','San Francisco Del Monte');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','San Antonio');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Santa Cruz');
INSERT INTO address (cluster, city, barangay, area) values(1,'Quezon','Santa Cruz', 'Heroes Hill');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Nayong Kanluran');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Paligsahan');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Laging Handa');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Sacred Heart');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Obrero');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Kamuning');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Roxas');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Kalusugan');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Kristong Hari');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Pinagkaisahan');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Mariana');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Immaculate Concepcion');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Damayang Lagi');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Valencia');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Horseshoe');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Kaunlaran');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','Bagong Lipunan ng Crame');
INSERT INTO address (cluster, city, barangay) values(1,'Quezon','San Martin De Porres');
INSERT INTO address (cluster, city) values (1,'San Juan');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Addition Hills');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Bagong Silang');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Barangka Drive');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Barangka Ibaba');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Barangka Itaas');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Burol');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Daang Bakal');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Hagdan Bato Itaas');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Hagdan Bato Libis');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Harapin Ang Bukas');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Hulo');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Mabini - J. Rizal');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Malamig');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Mauway');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Namayan');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'New Zañiga');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Old Zañiga');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Pag-Asa');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Plainview');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Pleasant Hills');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Poblacion');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'San Jose');
INSERT INTO address (cluster, city, barangay) values (1,'Mandaluyong' ,'Vergara');
INSERT INTO address(cluster,city, barangay, avenue) values (1,'Mandaluyong','Highway Hills','Athena Loop');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Highway Hills','Venus');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Highway Hills','Olympus');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Highway Hills','King''s Road');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Highway Hills','Calbayog');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Highway Hills','Samat');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Highway Hills','Queen''s Road');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Highway Hills','Dr. Jose Fernando');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Highway Hills','Banahaw');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Highway Hills','Mariveles');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Highway Hills','Kanlaon');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Highway Hills','Sinag');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Highway Hills','Malinao');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Highway Hills','L. Esteban');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Highway Hills','Sultan');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Malamig','Sierra Madre');
INSERT INTO address(cluster,city, barangay, avenue) values (1,'Mandaluyong','Malamig','Domingo M. Guevara');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Malamig','Cordillera');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Malamig','Arayat');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Malamig','Makiling');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Malamig','Dansalan');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Malamig','Mayon');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Malamig','Lunas');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Barangka Ilaya','Pinatubo');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Barangka Ilaya','Lion''s Road');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Barangka Ilaya','Apo');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Barangka Ilaya','Mayon');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Barangka Ilaya','Simeon Cruz');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Barangka Ilaya','Dansalan');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Barangka Ilaya','San Roque');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Notre Dame');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Harvard');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Fordham');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Wack wack Road');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Magnolia');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Princeton');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Stanford');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Yale');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Cornell');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Old Wack Wack Road');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Connecticut');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Duke');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','La Salle');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Wisconsin');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Richmond');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Wyoming');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','N. Western');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Maryland');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Colgate');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Holy Cross');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Lafayette');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Kansas');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Columbia');
INSERT INTO address(cluster,city, barangay, street) values (1,'Mandaluyong','Wack wack Greenhills','Florida');
INSERT INTO address(cluster,city, barangay) values (1, 'Manila'	, '892');
INSERT INTO address(cluster,city, barangay) values (1, 'Manila'	, '893');
INSERT INTO address(cluster,city, barangay) values (1, 'Manila'	, '894');
INSERT INTO address(cluster,city, barangay) values (1, 'Manila'	, '895');
INSERT INTO address(cluster,city, barangay) values (1, 'Manila'	, '896');
INSERT INTO address(cluster,city, barangay) values (1, 'Manila'	, '897');
INSERT INTO address(cluster,city, barangay) values (1, 'Manila'	, '898');
INSERT INTO address(cluster,city, barangay) values (1, 'Manila'	, '899');
INSERT INTO address(cluster,city, barangay) values (1, 'Manila'	, '900');
INSERT INTO address(cluster,city, barangay) values (1, 'Manila'	, '901');
INSERT INTO address(cluster,city, barangay) values (1, 'Manila'	, '902');
INSERT INTO address(cluster,city, barangay) values (1, 'Manila'	, '903');
INSERT INTO address(cluster,city, barangay) values (1, 'Manila'	, '904');
INSERT INTO address(cluster,city, barangay) values (1, 'Manila'	, '905');


--CLUSTER EAST 2 -> 2
INSERT INTO address(cluster,city, district) values (2,'Manila', 'Sampaloc');
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Apolonio Samson');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Masambong');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Damayan');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Paraiso');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Mariblo');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Talayan');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Tatalon');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Doña Imelda');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Santol');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Santo Niño');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'San Isidro');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Doña Aurora');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Don Manuel');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Doña Josefa');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Santa Teresa');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Lourdes');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Santo Domingo');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Siena');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'St. Peter');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Maharlika');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'N.S. Amoranto');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Paang Bundok');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Salvacion');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'San Isidro Labrador');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Balong Bato');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Unang Sigaw');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Balingasa');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Pagibig sa Nayon');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Damar');		
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'San Jose');	
INSERT INTO address(cluster,city, barangay,area) values (2,'Quezon', 'Balintawak','Parkway Village');
INSERT INTO address(cluster,city, barangay) values (2,'Quezon', 'Damar');		
INSERT INTO address(cluster,city, district) values (2,'Quezon', 'La Loma');

--CLUSTER EAST 3 -> 3
INSERT INTO address(cluster,province, city) values (3, 'Rizal','Taytay');
INSERT INTO address(cluster,province, city) values (3, 'Rizal','Cainta');
INSERT INTO address(cluster,province, city) values (3, 'Rizal','San Mateo');
INSERT INTO address(cluster,province, city) values (3, 'Rizal','Antipolo');
INSERT INTO address(cluster,city) values (3, 'Marikina');
INSERT INTO address(cluster,city) values (3, 'Pasig');
INSERT INTO address(cluster,city, barangay) values (3, 'Mandaluyong','Buayang Bato');
INSERT INTO address(cluster,city, barangay) values (3, 'Mandaluyong','Highway Hills');
INSERT INTO address(cluster,city, barangay, street) values (3, 'Mandaluyong','Highway Hills','United');
INSERT INTO address(cluster,city, barangay, street) values (3, 'Mandaluyong','Highway Hills','William' );
INSERT INTO address(cluster,city, barangay, street) values (3, 'Mandaluyong','Highway Hills','Pines' );
INSERT INTO address(cluster,city, barangay, street) values (3, 'Mandaluyong','Highway Hills','Union' );
INSERT INTO address(cluster,city, barangay, street) values (3, 'Mandaluyong','Highway Hills','Sheridan' );
INSERT INTO address(cluster,city, barangay, street) values (3, 'Mandaluyong','Highway Hills','Reliance' );
INSERT INTO address(cluster,city, barangay, street) values (3, 'Mandaluyong','Highway Hills','Santa Cristo' );
INSERT INTO address(cluster,city, barangay, street) values (3, 'Mandaluyong','Highway Hills','Mayflower' );
INSERT INTO address(cluster,city, barangay) values (3, 'Quezon','Bagumbayan' );
INSERT INTO address(cluster,city, area) values (3, 'Quezon','Green Meadows Subdivision' );
INSERT INTO address(cluster,city, barangay) values (3, 'Quezon','White Plains' );
INSERT INTO address(cluster,city, district, avenue) values (3, 'Quezon','Ugong Norte','Temple Drive	' );
INSERT INTO address(cluster,city, district, street) values (3, 'Quezon','Ugong Norte','Giraffe');

--CLUSTER EAST 4 -> 4
INSERT INTO address(cluster,city, barangay,area) values (4, 'Quezon','Ugong Norte','Corinthian Gardens');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Camp Aguinaldo');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Socorro');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','San Roque');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Bayanihan');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Villa Maria Clara');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Masagana');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Dioquino Zobel');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Milagrosa');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Tagumpay');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Bagumbuhay');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Mangga');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Marilag');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Escopa');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Blue Ridge');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Project 4');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Project 3');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','E. Rodriguez');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Silangan');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Botocan');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Quirino 2');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Claro');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Quirino 3');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Amihan');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Duyan-Duyan');
INSERT INTO address(cluster,city, district) values (4, 'Quezon','Loyola Heights');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Kamias');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Pinyahan');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Central');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','San Vicente');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Old Capitol Site');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','U.P. Ayala Technohub');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','U.P. Village');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Teacher''s Village');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Krus na Ligas');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Sikatuna');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Malaya');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Pansol');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Vasra');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Project 6');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Bago Bantay');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Bagong Pag-asa');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Santo Cristo');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Ramon Magsaysay');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Alicia');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Bahay Toro');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Project 8');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Baesa');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Sangandaan');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Talipapa');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Sauyo');
INSERT INTO address(cluster,city, district) values (4, 'Quezon','Tandang Sora');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Pasong Tamo');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Holy Spirit');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Matandang Balara');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Old Balara');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Batasan Hills');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Payatas');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Bagong Silangan');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','North Fairview');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Fairview');
INSERT INTO address(cluster,city, district) values (4, 'Quezon','Commonwealth');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Bagbag');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','San Bartolome');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Gulod');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Santa Lucia');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Santa Monica');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Capri');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Nagkaisang Nayon');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','San Agustin');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Kaligayahan');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Pasong Putik');
INSERT INTO address(cluster,city, barangay) values (4, 'Quezon','Greater Lagro');
INSERT INTO address(cluster,city, district) values (4, 'Quezon','Novaliches');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Tierra Pura Homes');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Sanville Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Wilsonville Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Doña Faustina Village');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Don Enrique Heights');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','NIA Village');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Mapayapa Village');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Ferndale Homes');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Fern Village');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Greenview Executive Village');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Doña Petrona Village');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Mendoza Village');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','BIR Village');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Britanny Neopolitan Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','New Haven Village');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Villa Vienna');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Lagro Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Goodwill Homes 2');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','El Pueblo One Condominium');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Ayala Heights');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Filinvest 1 Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Filinvest 2 Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Mountain View Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Spring Valley');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Parkwood Hills Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','New Capitol Estate');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Tivoli Royale');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Don Antonio Royale Estate');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Dela Costa Homes');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Monte Vista Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Cinco Hermanos Village');
INSERT INTO address(cluster,city, area) values (4, 'Quezon','Union Square Condominium');
INSERT INTO address(cluster,city, barangay) values (4, 'Caloocan (North)','169');
INSERT INTO address(cluster,city, barangay) values (4, 'Caloocan (North)','168');
INSERT INTO address(cluster,city, barangay) values (4, 'Caloocan (North)','170');
INSERT INTO address(cluster,city, barangay) values (4, 'Caloocan (North)','171');
INSERT INTO address(cluster,city, barangay) values (4, 'Caloocan (North)','120');
INSERT INTO address(cluster,city, barangay) values (4, 'Caloocan (North)','173');
INSERT INTO address(cluster,city, barangay) values (4, 'Caloocan (North)','174 (Camarin)');
INSERT INTO address(cluster,city, barangay) values (4, 'Caloocan (North)','175');
INSERT INTO address(cluster,city, barangay) values (4, 'Caloocan (North)','177');
INSERT INTO address(cluster,city, barangay) values (4, 'Caloocan (North)','178');
INSERT INTO address(cluster,city, barangay) values (4, 'Caloocan (North)','179');
INSERT INTO address(cluster,city, barangay) values (4, 'Caloocan (North)','180');
INSERT INTO address(cluster,city, barangay) values (4, 'Caloocan (North)','183');
INSERT INTO address(cluster,city, barangay) values (4, 'Caloocan (North)','185');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Solar UrbanHomes North');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Evergreen Executive Village');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Seville Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Maginhawa Village');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Social Homes Inc');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Villa Angelica Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Villa Magdalena 2');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','North Olympus 1 Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Merry Homes 2 Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Zamora Compound');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Maria Luisa Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Rainbow Village 5');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Amparo Novaville Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Sampaguita Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Capitol Homesite Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Palmera Homes Spring 1');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Laforteza Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Cielito Homes');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Sacred Heart Village 4');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','H. Dela Costa Homes 2');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Amparo Subdivision');
INSERT INTO address(cluster,city, area) values (4, 'Caloocan (North)','Bankers Village 2');
INSERT INTO address(cluster,city, barangay) values (4, 'Caloocan (North)','Novaliches');

--CLUSTER NORTH 1 -> 5
INSERT INTO address(cluster,city, barangay) values (5, 'Caloocan (North)','167 (Llano)');
INSERT INTO address(cluster,city, barangay) values (5, 'Caloocan (North)','166 (Kaybiga)');		
INSERT INTO address(cluster,city, barangay) values (5, 'Caloocan (North)','165 (Bagbaguin)');		
INSERT INTO address(cluster,city, barangay) values (5, 'Caloocan (North)','Whispering Palms Subdivision');
INSERT INTO address(cluster,city) values (5, 'Valenzuela');
INSERT INTO address(cluster,city, barangay) values (5, 'Malabon','Portrero');
INSERT INTO address(cluster,city, barangay) values (5, 'Malabon','Tinajeros');
INSERT INTO address(cluster,city, barangay) values (5, 'Malabon','Acacia');
INSERT INTO address(cluster,city, barangay) values (5, 'Malabon','Tugatog');
INSERT INTO address(cluster,city, barangay) values (5, 'Malabon','Tonsuya');
INSERT INTO address(cluster,city, barangay) values (5, 'Malabon','Niugan');
INSERT INTO address(cluster,city, barangay) values (5, 'Malabon','Catmon');
INSERT INTO address(cluster,city, barangay) values (5, 'Malabon','Muzon');
INSERT INTO address(cluster,city, barangay) values (5, 'Malabon','Panghulo');
INSERT INTO address(cluster,city, barangay) values (5, 'Malabon','Maysilo');
INSERT INTO address(cluster,city, barangay) values (5, 'Malabon','Santolan');
INSERT INTO address(cluster,city, barangay) values (5, 'Malabon','Dampalit');
INSERT INTO address(cluster,city, barangay) values (5, 'Caloocan (South)','21');
INSERT INTO address(cluster,city, barangay) values (5, 'Caloocan (South)','23');
INSERT INTO address(cluster,city, barangay) values (5, 'Caloocan (South)','24');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Maypajo');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Marulas');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Grace Park West');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Monumento');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Caimito Rd');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Heroes Del 96');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','PNR Compound');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','University Hills Subdivision');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Morning Breeze Subdivision');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Grace Park East');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Balintawak');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Dorotea Compound');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Barrio San Jose');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Bagong Barrio West');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Bagong Barrio East');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Baesa');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Libis Baesa');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Libis Reparo');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Santa Quiteria');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','Talipapa');
INSERT INTO address(cluster,city, area) values (5, 'Caloocan (South)','The Avenue Residences');

--CLUSTER NORTH 2 -> 6
INSERT INTO address(cluster,city, barangay) values(6, 'Malabon','San Agustin');
INSERT INTO address(cluster,city, barangay) values(6, 'Malabon','Ibaba');
INSERT INTO address(cluster,city, barangay) values(6, 'Malabon','Concepcion');
INSERT INTO address(cluster,city, barangay) values(6, 'Malabon','Baritan');
INSERT INTO address(cluster,city, barangay) values(6, 'Malabon','Bayan Bayanan');
INSERT INTO address(cluster,city, barangay) values(6, 'Malabon','Flores');
INSERT INTO address(cluster,city, barangay) values(6, 'Malabon','Hulong Duhat');
INSERT INTO address(cluster,city, barangay) values(6, 'Malabon','Tañong');
INSERT INTO address(cluster,city, barangay) values(6, 'Malabon','Longos');
INSERT INTO address(cluster,city) values(6, 'Navotas');
INSERT INTO address(cluster,city, area) values(6, 'Caloocan (South)','Sangandaan');
INSERT INTO address(cluster,city, area) values(6, 'Caloocan (South)','Dagat Dagatan');
INSERT INTO address(cluster,city, area) values(6, 'Caloocan (South)','Poblacion');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','20');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','22');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','1');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','2');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','3');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','4');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','5');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','6');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','7');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','8');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','9');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','10');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','11');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','12');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','13');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','14');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','15');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','16');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','17');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','18');
INSERT INTO address(cluster,city, barangay) values(6, 'Caloocan (South)','19');
INSERT INTO address(cluster,city, district) values(6, 'Manila','Tondo');
INSERT INTO address(cluster,city, district) values(6, 'Manila','San Nicholas');	

--CLUSTER CENTRAL 1 -> 7

INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Bel-Air');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Carmona');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Cembo');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Comembo');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Dasmariñas');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','East Rembo');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Forbes Park');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Guadalupe Nuevo');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Guadalupe Viejo');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Kasilawan');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','La Paz');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Olympia');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Pembo');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Pinagkaisahan');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Pio del Pilar');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Pitogo');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Poblacion');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Rizal');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','San Antonio');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','San Lorenzo');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Santa Cruz');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Singkamas');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','South Cembo');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Tejeros');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Urdaneta');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','Valenzuela');
INSERT INTO address(cluster, city, barangay) values(7, 'Makati','West Rembo');

--CLUSTER CENTRAL 2 -> 8
INSERT INTO address(cluster, city, district) values(8, 'Manila','Pandacan');
INSERT INTO address(cluster, city, district) values(8, 'Manila','Paco');
INSERT INTO address(cluster, city, district) values(8, 'Manila','Ermita');
INSERT INTO address(cluster, city, district) values(8, 'Manila','Malate');
INSERT INTO address(cluster, city, district) values(8, 'Manila','San Andres');	
INSERT INTO address(cluster, city, district) values(8, 'Manila','Santa Ana');
INSERT INTO address(cluster, city, area) values(8, 'Makati','Palanan');
INSERT INTO address(cluster, city, area) values(8, 'Makati','Bangkal');
INSERT INTO address(cluster, city, area) values(8, 'Makati','San Isidro');

--CLUSTER WEST 1 -> 9
INSERT INTO address(cluster, city, district) values(9,'Manila','Santa Cruz');
INSERT INTO address(cluster, city, district) values(9,'Manila','Binondo');
INSERT INTO address(cluster, city, district) values(9,'Manila','Quiapo');

--CLUSTER WEST 2 -> 10
INSERT INTO address(cluster, city, district) values(10,'Manila','Port Area');
INSERT INTO address(cluster, city, district) values(10,'Manila','Baseco Compound');
INSERT INTO address(cluster, city, district) values(10,'Manila','Intramuros');
INSERT INTO address(cluster, city, district) values(10,'Manila','San Miguel');
INSERT INTO address(cluster, city, district) values(10,'Manila','Santa Mesa');

--CLUSTER SOUTH 1 -> 11
INSERT INTO address(cluster,city) values(11,'Taguig');
INSERT INTO address(cluster,city) values(11,'Pasay');
INSERT INTO address(cluster,city) values(11,'Pateros');
INSERT INTO address(cluster,city, barangay) values(11,'Makati','Magallanes');

--CLUSTER SOUTH 2 -> 12
INSERT INTO address(cluster,city) values(12,'Parañaque');
INSERT INTO address(cluster,city) values(12,'Las Piñas');
INSERT INTO address(cluster,city) values(12,'Muntinlupa');


/*creates table for package*/
CREATE TABLE package(
	id serial primary key not null,
	serial_no varchar, 
	address int not null references address (id) on delete cascade on update cascade,
	length real not null,
	width real not null,
	height real not null,
	weight real not null,
	height_constraint real not null,
	weight_constraint real not null,
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

/*INSERT INTO package values(default, 1, 120, 1,50,0,0,0,now(),default);*/

/*
CREATE TABLE corner(
	id serial primary key not null,
	cluster int not null references cluster (id) on delete cascade on update cascade,
	x real not null,
	y real not null,
	z real not null
);
*/
