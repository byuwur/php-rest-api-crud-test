-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 27-09-2023 a las 03:57:45
-- Versión del servidor: 8.0.27
-- Versión de PHP: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `php-rest-api-crud-test`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `users_ID` int NOT NULL,
  `entries_ID` int NOT NULL,
  `COMMENT` varchar(99) NOT NULL,
  `TIMESTAMP` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_comments_users_idx` (`users_ID`),
  KEY `fk_comments_entries1_idx` (`entries_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`ID`, `users_ID`, `entries_ID`, `COMMENT`, `TIMESTAMP`) VALUES
(1, 2, 1, 'Comment on the first entry', '2023-09-22 10:30:00'),
(2, 3, 1, 'Another comment on the first entry', '2023-09-22 11:30:00'),
(3, 1, 2, 'Comment on user1\'s entry', '2023-09-22 12:30:00'),
(4, 2, 3, 'Comment on user2\'s entry', '2023-09-22 13:30:00'),
(5, 1, 2, 'User1\'s comment on user1\'s entry', '2023-09-22 14:00:00'),
(6, 3, 2, 'User3\'s comment on user1\'s entry', '2023-09-22 15:00:00'),
(7, 2, 4, 'User2\'s comment on user3\'s entry', '2023-09-22 16:00:00'),
(8, 1, 4, 'User1\'s comment on user3\'s entry', '2023-09-22 17:00:00'),
(9, 3, 3, 'User3\'s comment on user2\'s entry', '2023-09-22 18:00:00'),
(10, 2, 1, 'User2\'s comment on the first entry', '2023-09-22 19:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entries`
--

DROP TABLE IF EXISTS `entries`;
CREATE TABLE IF NOT EXISTS `entries` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `users_ID` int NOT NULL,
  `ENTRY` varchar(99) NOT NULL,
  `TIMESTAMP` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_entries_users1_idx` (`users_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `entries`
--

INSERT INTO `entries` (`ID`, `users_ID`, `ENTRY`, `TIMESTAMP`) VALUES
(1, 1, 'This is the first entry', '2023-09-22 10:00:00'),
(2, 1, 'Another entry by user1', '2023-09-22 11:00:00'),
(3, 2, 'Entry by user2', '2023-09-22 12:00:00'),
(4, 3, 'User3\'s entry', '2023-09-22 13:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(99) NOT NULL,
  `PASSWORD` varchar(99) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`ID`, `USERNAME`, `PASSWORD`) VALUES
(1, 'user1', 'password1'),
(2, 'user2', 'password2'),
(3, 'user3', 'password3');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_entries1` FOREIGN KEY (`entries_ID`) REFERENCES `entries` (`ID`),
  ADD CONSTRAINT `fk_comments_users` FOREIGN KEY (`users_ID`) REFERENCES `users` (`ID`);

--
-- Filtros para la tabla `entries`
--
ALTER TABLE `entries`
  ADD CONSTRAINT `fk_entries_users1` FOREIGN KEY (`users_ID`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
