SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `articoli_carrello` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_carrello` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `quantita` int(11) NOT NULL CHECK (`quantita` > 0),
  `prezzo` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_carrello` (`id_carrello`),
  KEY `id_prodotto` (`id_prodotto`),
  CONSTRAINT `articoli_carrello_ibfk_1` FOREIGN KEY (`id_carrello`) REFERENCES `carrelli` (`id`),
  CONSTRAINT `articoli_carrello_ibfk_2` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotti` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `articoli_ordine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ordine` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `quantita` int(11) NOT NULL CHECK (`quantita` > 0),
  `prezzo` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_ordine` (`id_ordine`),
  KEY `id_prodotto` (`id_prodotto`),
  CONSTRAINT `articoli_ordine_ibfk_1` FOREIGN KEY (`id_ordine`) REFERENCES `ordini` (`id`),
  CONSTRAINT `articoli_ordine_ibfk_2` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotti` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `carrelli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utente` int(11) NOT NULL,
  `id_stato_carrello` int(11) NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_utente` (`id_utente`),
  KEY `id_stato_carrello` (`id_stato_carrello`),
  CONSTRAINT `carrelli_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`),
  CONSTRAINT `carrelli_ibfk_2` FOREIGN KEY (`id_stato_carrello`) REFERENCES `stati_carrelli` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `id_categoria_padre` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria_padre` (`id_categoria_padre`),
  CONSTRAINT `categorie_ibfk_1` FOREIGN KEY (`id_categoria_padre`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categorie` (`id`, `nome`, `descrizione`, `id_categoria_padre`) VALUES
(1, 'Manuali', 'Manuali di ambientazione e avventura', NULL),
(2, 'Dadi', 'Set di dadi per il D20 system e altri', NULL),
(3, 'Accessori', 'Accessori vari per giochi di ruolo e da tavolo', NULL),
(4, 'Vestiario', 'Abbigliamento e costumi a tema', NULL),
(5, 'Casa', 'Articoli per la casa a tema fantasy e giochi di ruolo', NULL);

CREATE TABLE `notifiche` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utente` int(11) NOT NULL,
  `messaggio` text NOT NULL,
  `id_stato_notifica` int(11) NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_utente` (`id_utente`),
  KEY `id_stato_notifica` (`id_stato_notifica`),
  CONSTRAINT `notifiche_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`),
  CONSTRAINT `notifiche_ibfk_2` FOREIGN KEY (`id_stato_notifica`) REFERENCES `stati_notifiche` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `ordini` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utente` int(11) NOT NULL,
  `id_stato_ordine` int(11) NOT NULL,
  `data_ordine` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_utente` (`id_utente`),
  KEY `id_stato_ordine` (`id_stato_ordine`),
  CONSTRAINT `ordini_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`),
  CONSTRAINT `ordini_ibfk_2` FOREIGN KEY (`id_stato_ordine`) REFERENCES `stati_ordini` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `prodotti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `id_venditore` int(11) NOT NULL,
  `titolo` varchar(150) NOT NULL,
  `descrizione` text NOT NULL,
  `prezzo` decimal(10,2) NOT NULL,
  `sconto` decimal(5,2) DEFAULT 0.00,
  `quantita_disponibile` int(11) NOT NULL,
  `immagine` varchar(250) NOT NULL,
  `edizione_limitata` boolean NOT NULL DEFAULT 0,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_aggiornamento` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`),
  KEY `fk_venditore` (`id_venditore`),
  CONSTRAINT `fk_venditore` FOREIGN KEY (`id_venditore`) REFERENCES `utenti` (`id`),
  CONSTRAINT `prodotti_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `ruoli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `ruoli` (`id`, `nome`) VALUES
(1, 'cliente'),
(2, 'venditore');

CREATE TABLE `stati_carrelli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `stati_carrelli` (`id`, `nome`) VALUES
(1, 'aperto'),
(3, 'completato'),
(2, 'in elaborazione');

CREATE TABLE `stati_notifiche` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `stati_notifiche` (`id`, `nome`) VALUES
(2, 'letta'),
(1, 'non letta');

CREATE TABLE `stati_ordini` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `stati_ordini` (`id`, `nome`) VALUES
(3, 'consegnato'),
(1, 'in elaborazione'),
(2, 'spedito');

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `id_ruolo` int(11) NOT NULL,
  `data_registrazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultima_attivita` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  KEY `id_ruolo` (`id_ruolo`),
  CONSTRAINT `utenti_ibfk_1` FOREIGN KEY (`id_ruolo`) REFERENCES `ruoli` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;