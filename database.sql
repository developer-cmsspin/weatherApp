CREATE DATABASE `weatherapp` /*!40100 DEFAULT CHARACTER SET latin1 */;
CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ciudad` varchar(45) NOT NULL,
  `longitud` varchar(30) DEFAULT NULL,
  `latitud` varchar(30) DEFAULT NULL,
  `alias` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

CREATE TABLE `historico` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ciudad_id` int(10) unsigned NOT NULL,
  `humedad` varchar(45) DEFAULT NULL,
  `temperatura` varchar(45) DEFAULT NULL,
  `fecha_toma` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `locations` (`id`,`ciudad`,`longitud`,`latitud`,`alias`) VALUES (1,'Miami','-80.191788','25.761681',NULL);
INSERT INTO `locations` (`id`,`ciudad`,`longitud`,`latitud`,`alias`) VALUES (2,'Orlando ','-81.379234','28.538336',NULL);
INSERT INTO `locations` (`id`,`ciudad`,`longitud`,`latitud`,`alias`) VALUES (3,'New York','-73.935242','40.730610',NULL);
