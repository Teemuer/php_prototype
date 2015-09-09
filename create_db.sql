create database tuotedb;
use tuotedb;

CREATE TABLE IF NOT EXISTS `tuote` (
`id` int(10) unsigned NOT NULL,
  `nimi` varchar(30) NOT NULL,
  `kuvaus` varchar(500) DEFAULT NULL,
  `hinta` decimal(7,2) NOT NULL,
  `kuva` varchar(100),
  `kategoria` int(1) NOT NULL,
  `valmistaja` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
