
/*!40101 SET NAMES utf8mb4 */;
DROP TABLE users ;
--
-- Database: `corsophp`
--

-- ------- -------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `fiscalcode` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `age` tinyint(3) UNSIGNED NOT NULL,
 `avatar` varchar(24) ,
  `password` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `users`
  ADD UNIQUE KEY `u_fiscalcode` (`fiscalcode`),
  ADD UNIQUE KEY `u_email` (`email`) USING BTREE,
  ADD KEY `idx_username` (`username`(16));

INSERT  INTO users (id, username, email, fiscalcode, age, avatar, password)
VALUES  ( NULL, 'hidran','hidran@gmail.com','QAWSEDRFTGYHUJIK',45,NULL,'$2y$10$6aWMt8OAsD1sIpmzm9b1Oenf/hw0mdRZ2Nce31KWJxHExNuax1jpC');