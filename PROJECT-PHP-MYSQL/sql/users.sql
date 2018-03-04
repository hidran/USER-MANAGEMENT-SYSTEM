-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Creato il: Ago 12, 2016 alle 18:08
-- Versione del server: 5.5.47
-- Versione PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
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