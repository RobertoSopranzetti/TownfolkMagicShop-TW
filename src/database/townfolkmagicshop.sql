-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- Host: 127.0.0.1:3307
-- Creato il: Feb 05, 2025 alle 22:47
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8mb4;

-- Database: `townfolkmagicshop`

-- Struttura della tabella `articoli_carrello`
CREATE TABLE `articoli_carrello` (
  `id_carrello` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `quantita` int(11) NOT NULL CHECK (`quantita` > 0),
  `prezzo` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Struttura della tabella `articoli_ordine`
CREATE TABLE `articoli_ordine` (
  `id_ordine` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `quantita` int(11) NOT NULL CHECK (`quantita` > 0),
  `prezzo` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `articoli_ordine`
INSERT INTO `articoli_ordine` (`id_ordine`, `id_prodotto`, `quantita`, `prezzo`) VALUES
(1, 4, 3, 75.00),
(2, 7, 1, 70.00),
(2, 8, 2, 30.00);

-- Struttura della tabella `carrelli`
CREATE TABLE `carrelli` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_stato_carrello` int(11) NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `carrelli`
INSERT INTO `carrelli` (`id`, `id_utente`, `id_stato_carrello`, `data_creazione`) VALUES
(1, 10, 1, '2025-02-05 11:22:33');

-- Struttura della tabella `categorie`
CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `id_categoria_padre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `categorie`
INSERT INTO `categorie` (`id`, `nome`, `descrizione`, `id_categoria_padre`) VALUES
(1, 'Manuali', 'Manuali di ambientazione e avventura', NULL),
(2, 'Dadi', 'Set di dadi per il D20 system e altri', NULL),
(3, 'Accessori', 'Accessori vari per giochi di ruolo e da tavolo', NULL),
(4, 'Vestiario', 'Abbigliamento e costumi a tema', NULL),
(5, 'Casa', 'Articoli per la casa a tema fantasy e giochi di ruolo', NULL);

-- Struttura della tabella `notifiche`
CREATE TABLE `notifiche` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `messaggio` text NOT NULL,
  `id_stato_notifica` int(11) NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `notifiche`
INSERT INTO `notifiche` (`id`, `id_utente`, `messaggio`, `id_stato_notifica`, `data_creazione`) VALUES
(1, 11, 'Il prodotto \'Set dadi Blu completo\' è stato ordinato. Quantità ordinata: 3.', 2, '2025-02-05 16:04:38'),
(6, 11, 'Il prodotto \'Libro Imprese Eroiche\' è esaurito.', 1, '2025-02-05 21:34:32'),
(7, 11, 'Il prodotto \'Libro Imprese Eroiche\' è stato ordinato. Quantità ordinata: 1.', 1, '2025-02-05 21:34:33'),
(8, 11, 'Il prodotto \'Maglia LOTR\' è stato ordinato. Quantità ordinata: 2.', 1, '2025-02-05 21:34:33'),
(9, 10, 'Il tuo ordine #2 è stato confermato. Sfruttalo bene nelle tue avventure!', 1, '2025-02-05 21:34:33'),
(10, 10, 'Il tuo ordine #2 è stato aggiornato allo stato: Consegnato.', 1, '2025-02-05 21:37:45');

-- Struttura della tabella `ordini`
CREATE TABLE `ordini` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_stato_ordine` int(11) NOT NULL,
  `data_ordine` timestamp NOT NULL DEFAULT current_timestamp(),
  `spesa_complessiva` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `ordini`
INSERT INTO `ordini` (`id`, `id_utente`, `id_stato_ordine`, `data_ordine`, `spesa_complessiva`) VALUES
(1, 10, 3, '2025-02-05 16:04:37', 75.00),
(2, 10, 3, '2025-02-05 21:34:32', 100.00);

-- Struttura della tabella `prodotti`
CREATE TABLE `prodotti` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_venditore` int(11) NOT NULL,
  `titolo` varchar(150) NOT NULL,
  `descrizione` text NOT NULL,
  `prezzo` decimal(10,2) NOT NULL,
  `sconto` decimal(5,2) DEFAULT 0.00,
  `quantita_disponibile` int(11) NOT NULL,
  `immagine` varchar(250) NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_aggiornamento` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `edizione_limitata` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `prodotti`
INSERT INTO `prodotti` (`id`, `id_categoria`, `id_venditore`, `titolo`, `descrizione`, `prezzo`, `sconto`, `quantita_disponibile`, `immagine`, `data_creazione`, `data_aggiornamento`, `edizione_limitata`) VALUES
(4, 2, 11, 'Set dadi Blu completo', 'dal d2 al d100, dadi completi per tutti i gusti!', 25.00, 0.00, 117, 'dadi_custom_4.jpeg', '2025-02-04 18:27:36', '2025-02-05 16:04:38', 0),
(5, 2, 11, 'Set dadi basico', 'Il tuo primo set per giocare al più famoso gioco di ruolo del mondo!!', 5.00, 0.00, 140, 'dadi_test.jpg', '2025-02-05 21:12:49', NULL, 0),
(6, 3, 11, 'Torre Dadi Drago', 'Aumenta la tua credibilità come master, con questa torre vedrai come avranno paura i tuoi giocatori', 40.00, 0.00, 50, 'torre_dadi.jpg', '2025-02-05 21:28:27', NULL, 0),
(7, 1, 11, 'Libro Imprese Eroiche', 'Guarda le gesta che grandi eroi prima di te hanno compiuto! - Edizione Limitata', 70.00, 0.00, 0, 'libro-delle-imprese-eroiche.jpg', '2025-02-05 21:29:37', '2025-02-05 21:34:32', 1),
(8, 4, 11, 'Maglia LOTR', 'La maglia che gandalf usava nella terra di mezzo!', 15.00, 0.00, 168, 'maglia_fantasy.jpg', '2025-02-05 21:30:26', '2025-02-05 21:34:33', 0);

-- Struttura della tabella `ruoli`
CREATE TABLE `ruoli` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `ruoli`
INSERT INTO `ruoli` (`id`, `nome`) VALUES
(1, 'cliente'),
(2, 'venditore');

-- Struttura della tabella `stati_carrelli`
CREATE TABLE `stati_carrelli` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `stati_carrelli`
INSERT INTO `stati_carrelli` (`id`, `nome`) VALUES
(1, 'aperto'),
(3, 'completato'),
(2, 'in elaborazione');

-- Struttura della tabella `stati_notifiche`
CREATE TABLE `stati_notifiche` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `stati_notifiche`
INSERT INTO `stati_notifiche` (`id`, `nome`) VALUES
(2, 'letta'),
(1, 'non letta');

-- Struttura della tabella `stati_ordini`
CREATE TABLE `stati_ordini` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `stati_ordini`
INSERT INTO `stati_ordini` (`id`, `nome`) VALUES
(3, 'consegnato'),
(1, 'in elaborazione'),
(2, 'spedito');

-- Struttura della tabella `utenti`
CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `id_ruolo` int(11) NOT NULL,
  `data_registrazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultima_attivita` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `utenti`
INSERT INTO `utenti` (`id`, `email`, `username`, `password`, `nome`, `cognome`, `id_ruolo`, `data_registrazione`, `ultima_attivita`) VALUES
(6, 'email.diesempio@fantasy.gh', 'Ares', '$2y$10$qGnpY.r7mBdtLZ2TixjmS.pwB/uvtTLVyZP1TVda/tFJjHU72TwrK', 'Ares', 'War', 1, '2025-02-04 13:39:59', NULL),
(7, 'email.atlas@fantasy.gh', 'AtlasSelaerethLV8', '$2y$10$4AJu0HdRNYefllrhhTmFpODeF0TGGjfAowpf8r.Y5vIG/tUf6e7Y.', 'Atlas', 'Selaereth', 1, '2025-02-04 13:55:11', NULL),
(10, 'ginopino@blogtw.com', 'GinoPino', '$2y$10$fWd/NHgfWpygYKnX3Im4OePgBuLpjg8LyExeLLhu2ttpi5Uf1dN4C', 'Gino', 'Pino', 1, '2025-02-04 14:14:28', NULL),
(11, 'mastro.ordigno@bomb.hy', 'Bombarolo', '$2y$10$EQKCIS0L.PJCrdIaZeBvv.DUWiWpySCw3twXdbqb7bmNZUCvN.ZZO', 'Mastro', 'Ordigno', 2, '2025-02-04 14:18:12', NULL);

-- Indici per le tabelle `articoli_carrello`
ALTER TABLE `articoli_carrello`
  ADD PRIMARY KEY (`id_carrello`,`id_prodotto`),
  ADD KEY `id_prodotto` (`id_prodotto`);

-- Indici per le tabelle `articoli_ordine`
ALTER TABLE `articoli_ordine`
  ADD PRIMARY KEY (`id_ordine`,`id_prodotto`),
  ADD KEY `id_prodotto` (`id_prodotto`);

-- Indici per le tabelle `carrelli`
ALTER TABLE `carrelli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_stato_carrello` (`id_stato_carrello`);

-- Indici per le tabelle `categorie`
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria_padre` (`id_categoria_padre`);

-- Indici per le tabelle `notifiche`
ALTER TABLE `notifiche`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_stato_notifica` (`id_stato_notifica`);

-- Indici per le tabelle `ordini`
ALTER TABLE `ordini`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_stato_ordine` (`id_stato_ordine`);

-- Indici per le tabelle `prodotti`
ALTER TABLE `prodotti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `fk_venditore` (`id_venditore`);

-- Indici per le tabelle `ruoli`
ALTER TABLE `ruoli`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

-- Indici per le tabelle `stati_carrelli`
ALTER TABLE `stati_carrelli`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

-- Indici per le tabelle `stati_notifiche`
ALTER TABLE `stati_notifiche`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

-- Indici per le tabelle `stati_ordini`
ALTER TABLE `stati_ordini`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

-- Indici per le tabelle `utenti`
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_ruolo` (`id_ruolo`);

-- AUTO_INCREMENT per le tabelle `carrelli`
ALTER TABLE `carrelli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- AUTO_INCREMENT per le tabelle `categorie`
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

-- AUTO_INCREMENT per le tabelle `notifiche`
ALTER TABLE `notifiche`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

-- AUTO_INCREMENT per le tabelle `ordini`
ALTER TABLE `ordini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

-- AUTO_INCREMENT per le tabelle `prodotti`
ALTER TABLE `prodotti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

-- AUTO_INCREMENT per le tabelle `ruoli`
ALTER TABLE `ruoli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

-- AUTO_INCREMENT per le tabelle `stati_carrelli`
ALTER TABLE-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- Host: 127.0.0.1:3307
-- Creato il: Feb 05, 2025 alle 22:47
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8mb4;

-- Database: `townfolkmagicshop`

-- Struttura della tabella `articoli_carrello`
CREATE TABLE `articoli_carrello` (
  `id_carrello` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `quantita` int(11) NOT NULL CHECK (`quantita` > 0),
  `prezzo` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Struttura della tabella `articoli_ordine`
CREATE TABLE `articoli_ordine` (
  `id_ordine` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `quantita` int(11) NOT NULL CHECK (`quantita` > 0),
  `prezzo` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `articoli_ordine`
INSERT INTO `articoli_ordine` (`id_ordine`, `id_prodotto`, `quantita`, `prezzo`) VALUES
(1, 4, 3, 75.00),
(2, 7, 1, 70.00),
(2, 8, 2, 30.00);

-- Struttura della tabella `carrelli`
CREATE TABLE `carrelli` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_stato_carrello` int(11) NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `carrelli`
INSERT INTO `carrelli` (`id`, `id_utente`, `id_stato_carrello`, `data_creazione`) VALUES
(1, 10, 1, '2025-02-05 11:22:33');

-- Struttura della tabella `categorie`
CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `id_categoria_padre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `categorie`
INSERT INTO `categorie` (`id`, `nome`, `descrizione`, `id_categoria_padre`) VALUES
(1, 'Manuali', 'Manuali di ambientazione e avventura', NULL),
(2, 'Dadi', 'Set di dadi per il D20 system e altri', NULL),
(3, 'Accessori', 'Accessori vari per giochi di ruolo e da tavolo', NULL),
(4, 'Vestiario', 'Abbigliamento e costumi a tema', NULL),
(5, 'Casa', 'Articoli per la casa a tema fantasy e giochi di ruolo', NULL);

-- Struttura della tabella `notifiche`
CREATE TABLE `notifiche` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `messaggio` text NOT NULL,
  `id_stato_notifica` int(11) NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `notifiche`
INSERT INTO `notifiche` (`id`, `id_utente`, `messaggio`, `id_stato_notifica`, `data_creazione`) VALUES
(1, 11, 'Il prodotto \'Set dadi Blu completo\' è stato ordinato. Quantità ordinata: 3.', 2, '2025-02-05 16:04:38'),
(6, 11, 'Il prodotto \'Libro Imprese Eroiche\' è esaurito.', 1, '2025-02-05 21:34:32'),
(7, 11, 'Il prodotto \'Libro Imprese Eroiche\' è stato ordinato. Quantità ordinata: 1.', 1, '2025-02-05 21:34:33'),
(8, 11, 'Il prodotto \'Maglia LOTR\' è stato ordinato. Quantità ordinata: 2.', 1, '2025-02-05 21:34:33'),
(9, 10, 'Il tuo ordine #2 è stato confermato. Sfruttalo bene nelle tue avventure!', 1, '2025-02-05 21:34:33'),
(10, 10, 'Il tuo ordine #2 è stato aggiornato allo stato: Consegnato.', 1, '2025-02-05 21:37:45');

-- Struttura della tabella `ordini`
CREATE TABLE `ordini` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_stato_ordine` int(11) NOT NULL,
  `data_ordine` timestamp NOT NULL DEFAULT current_timestamp(),
  `spesa_complessiva` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `ordini`
INSERT INTO `ordini` (`id`, `id_utente`, `id_stato_ordine`, `data_ordine`, `spesa_complessiva`) VALUES
(1, 10, 3, '2025-02-05 16:04:37', 75.00),
(2, 10, 3, '2025-02-05 21:34:32', 100.00);

-- Struttura della tabella `prodotti`
CREATE TABLE `prodotti` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_venditore` int(11) NOT NULL,
  `titolo` varchar(150) NOT NULL,
  `descrizione` text NOT NULL,
  `prezzo` decimal(10,2) NOT NULL,
  `sconto` decimal(5,2) DEFAULT 0.00,
  `quantita_disponibile` int(11) NOT NULL,
  `immagine` varchar(250) NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_aggiornamento` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `edizione_limitata` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `prodotti`
INSERT INTO `prodotti` (`id`, `id_categoria`, `id_venditore`, `titolo`, `descrizione`, `prezzo`, `sconto`, `quantita_disponibile`, `immagine`, `data_creazione`, `data_aggiornamento`, `edizione_limitata`) VALUES
(4, 2, 11, 'Set dadi Blu completo', 'dal d2 al d100, dadi completi per tutti i gusti!', 25.00, 0.00, 117, 'dadi_custom_4.jpeg', '2025-02-04 18:27:36', '2025-02-05 16:04:38', 0),
(5, 2, 11, 'Set dadi basico', 'Il tuo primo set per giocare al più famoso gioco di ruolo del mondo!!', 5.00, 0.00, 140, 'dadi_test.jpg', '2025-02-05 21:12:49', NULL, 0),
(6, 3, 11, 'Torre Dadi Drago', 'Aumenta la tua credibilità come master, con questa torre vedrai come avranno paura i tuoi giocatori', 40.00, 0.00, 50, 'torre_dadi.jpg', '2025-02-05 21:28:27', NULL, 0),
(7, 1, 11, 'Libro Imprese Eroiche', 'Guarda le gesta che grandi eroi prima di te hanno compiuto! - Edizione Limitata', 70.00, 0.00, 0, 'libro-delle-imprese-eroiche.jpg', '2025-02-05 21:29:37', '2025-02-05 21:34:32', 1),
(8, 4, 11, 'Maglia LOTR', 'La maglia che gandalf usava nella terra di mezzo!', 15.00, 0.00, 168, 'maglia_fantasy.jpg', '2025-02-05 21:30:26', '2025-02-05 21:34:33', 0);

-- Struttura della tabella `ruoli`
CREATE TABLE `ruoli` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `ruoli`
INSERT INTO `ruoli` (`id`, `nome`) VALUES
(1, 'cliente'),
(2, 'venditore');

-- Struttura della tabella `stati_carrelli`
CREATE TABLE `stati_carrelli` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `stati_carrelli`
INSERT INTO `stati_carrelli` (`id`, `nome`) VALUES
(1, 'aperto'),
(3, 'completato'),
(2, 'in elaborazione');

-- Struttura della tabella `stati_notifiche`
CREATE TABLE `stati_notifiche` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `stati_notifiche`
INSERT INTO `stati_notifiche` (`id`, `nome`) VALUES
(2, 'letta'),
(1, 'non letta');

-- Struttura della tabella `stati_ordini`
CREATE TABLE `stati_ordini` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `stati_ordini`
INSERT INTO `stati_ordini` (`id`, `nome`) VALUES
(3, 'consegnato'),
(1, 'in elaborazione'),
(2, 'spedito');

-- Struttura della tabella `utenti`
CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `id_ruolo` int(11) NOT NULL,
  `data_registrazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultima_attivita` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `utenti`
INSERT INTO `utenti` (`id`, `email`, `username`, `password`, `nome`, `cognome`, `id_ruolo`, `data_registrazione`, `ultima_attivita`) VALUES
(6, 'email.diesempio@fantasy.gh', 'Ares', '$2y$10$qGnpY.r7mBdtLZ2TixjmS.pwB/uvtTLVyZP1TVda/tFJjHU72TwrK', 'Ares', 'War', 1, '2025-02-04 13:39:59', NULL),
(7, 'email.atlas@fantasy.gh', 'AtlasSelaerethLV8', '$2y$10$4AJu0HdRNYefllrhhTmFpODeF0TGGjfAowpf8r.Y5vIG/tUf6e7Y.', 'Atlas', 'Selaereth', 1, '2025-02-04 13:55:11', NULL),
(10, 'ginopino@blogtw.com', 'GinoPino', '$2y$10$fWd/NHgfWpygYKnX3Im4OePgBuLpjg8LyExeLLhu2ttpi5Uf1dN4C', 'Gino', 'Pino', 1, '2025-02-04 14:14:28', NULL),
(11, 'mastro.ordigno@bomb.hy', 'Bombarolo', '$2y$10$EQKCIS0L.PJCrdIaZeBvv.DUWiWpySCw3twXdbqb7bmNZUCvN.ZZO', 'Mastro', 'Ordigno', 2, '2025-02-04 14:18:12', NULL);

-- Indici per le tabelle `articoli_carrello`
ALTER TABLE `articoli_carrello`
  ADD PRIMARY KEY (`id_carrello`,`id_prodotto`),
  ADD KEY `id_prodotto` (`id_prodotto`);

-- Indici per le tabelle `articoli_ordine`
ALTER TABLE `articoli_ordine`
  ADD PRIMARY KEY (`id_ordine`,`id_prodotto`),
  ADD KEY `id_prodotto` (`id_prodotto`);

-- Indici per le tabelle `carrelli`
ALTER TABLE `carrelli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_stato_carrello` (`id_stato_carrello`);

-- Indici per le tabelle `categorie`
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria_padre` (`id_categoria_padre`);

-- Indici per le tabelle `notifiche`
ALTER TABLE `notifiche`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_stato_notifica` (`id_stato_notifica`);

-- Indici per le tabelle `ordini`
ALTER TABLE `ordini`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_stato_ordine` (`id_stato_ordine`);

-- Indici per le tabelle `prodotti`
ALTER TABLE `prodotti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `fk_venditore` (`id_venditore`);

-- Indici per le tabelle `ruoli`
ALTER TABLE `ruoli`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

-- Indici per le tabelle `stati_carrelli`
ALTER TABLE `stati_carrelli`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

-- Indici per le tabelle `stati_notifiche`
ALTER TABLE `stati_notifiche`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

-- Indici per le tabelle `stati_ordini`
ALTER TABLE `stati_ordini`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

-- Indici per le tabelle `utenti`
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_ruolo` (`id_ruolo`);

-- AUTO_INCREMENT per le tabelle `carrelli`
ALTER TABLE `carrelli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- AUTO_INCREMENT per le tabelle `categorie`
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

-- AUTO_INCREMENT per le tabelle `notifiche`
ALTER TABLE `notifiche`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

-- AUTO_INCREMENT per le tabelle `ordini`
ALTER TABLE `ordini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

-- AUTO_INCREMENT per le tabelle `prodotti`
ALTER TABLE `prodotti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

-- AUTO_INCREMENT per le tabelle `ruoli`
ALTER TABLE `ruoli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

-- AUTO_INCREMENT per le tabelle `stati_carrelli`
ALTER TABLE