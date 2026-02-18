CREATE DATABASE IF NOT EXISTS redsocial2;
USE redsocial2;


-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-02-2026 a las 23:42:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `redsocial2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `idComentario` int(11) NOT NULL,
  `idPost` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fechaPublicacion` datetime NOT NULL DEFAULT current_timestamp(),
  `contenido` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`idComentario`, `idPost`, `idUsuario`, `fechaPublicacion`, `contenido`) VALUES
(1, 1, 2, '2026-02-16 09:26:42', 'Comment 1 on Post 1 by User 2'),
(2, 1, 3, '2026-02-16 09:26:42', 'Comment 2 on Post 1 by User 3'),
(3, 1, 4, '2026-02-16 09:26:42', 'Comment 3 on Post 1 by User 4'),
(4, 2, 2, '2026-02-16 09:26:42', 'Comment 1 on Post 2 by User 2'),
(5, 2, 3, '2026-02-16 09:26:42', 'Comment 2 on Post 2 by User 3'),
(6, 2, 4, '2026-02-16 09:26:42', 'Comment 3 on Post 2 by User 4'),
(7, 3, 1, '2026-02-16 09:26:42', 'Comment 1 on Post 1 by User 1'),
(8, 3, 3, '2026-02-16 09:26:42', 'Comment 2 on Post 1 by User 3'),
(9, 3, 4, '2026-02-16 09:26:42', 'Comment 3 on Post 1 by User 4'),
(10, 4, 1, '2026-02-16 09:26:42', 'Comment 1 on Post 2 by User 1'),
(11, 4, 3, '2026-02-16 09:26:42', 'Comment 2 on Post 2 by User 3'),
(12, 4, 4, '2026-02-16 09:26:42', 'Comment 3 on Post 2 by User 4'),
(13, 5, 1, '2026-02-16 09:26:42', 'Comment 1 on Post 1 by User 1'),
(14, 5, 2, '2026-02-16 09:26:42', 'Comment 2 on Post 1 by User 2'),
(15, 5, 4, '2026-02-16 09:26:42', 'Comment 3 on Post 1 by User 4'),
(16, 6, 1, '2026-02-16 09:26:42', 'Comment 1 on Post 2 by User 1'),
(17, 6, 2, '2026-02-16 09:26:42', 'Comment 2 on Post 2 by User 2'),
(18, 6, 4, '2026-02-16 09:26:42', 'Comment 3 on Post 2 by User 4'),
(19, 7, 1, '2026-02-16 09:26:42', 'Comment 1 on Post 1 by User 1'),
(20, 7, 2, '2026-02-16 09:26:42', 'Comment 2 on Post 1 by User 2'),
(21, 7, 3, '2026-02-16 09:26:42', 'Comment 3 on Post 1 by User 3'),
(22, 8, 1, '2026-02-16 09:26:42', 'Comment 1 on Post 2 by User 1'),
(23, 8, 2, '2026-02-16 09:26:42', 'Comment 2 on Post 2 by User 2'),
(24, 8, 3, '2026-02-16 09:26:42', 'Comment 3 on Post 2 by User 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `idPost` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fechaPublicacion` datetime NOT NULL DEFAULT current_timestamp(),
  `contenido` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`idPost`, `idUsuario`, `fechaPublicacion`, `contenido`) VALUES
(1, 1, '2026-02-16 09:26:42', 'Post 1 from User 1'),
(2, 1, '2026-02-16 09:26:42', 'Post 2 from User 1'),
(3, 2, '2026-02-16 09:26:42', 'Post 1 from User 2'),
(4, 2, '2026-02-16 09:26:42', 'Post 2 from User 2'),
(5, 3, '2026-02-16 09:26:42', 'Post 1 from User 3'),
(6, 3, '2026-02-16 09:26:42', 'Post 2 from User 3'),
(7, 4, '2026-02-16 09:26:42', 'Post 1 from User 4'),
(8, 4, '2026-02-16 09:26:42', 'Post 2 from User 4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguidores`
--

CREATE TABLE `seguidores` (
  `idSeguidor` int(11) NOT NULL,
  `idSeguido` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguidores`
--

INSERT INTO `seguidores` (`idSeguidor`, `idSeguido`, `estado`) VALUES
(1, 2, 'aceptado'),
(1, 3, 'aceptado'),
(2, 1, 'pendiente'),
(2, 3, 'pendiente'),
(2, 4, 'pendiente'),
(3, 1, 'pendiente'),
(3, 2, 'pendiente'),
(3, 4, 'pendiente'),
(4, 1, 'pendiente'),
(4, 2, 'pendiente'),
(4, 3, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 0,
  `fechaRegistro` datetime NOT NULL DEFAULT current_timestamp(),
  `token` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombre`, `correo`, `contraseña`, `admin`, `activo`, `fechaRegistro`, `token`) VALUES
(1, 'User1', 'user1@example.com', '$2y$10$QbERimcev6WAj9H3.c/6KO2kFtJ/cQUmfe5c.zPxfaMFWzVsB2wmC', 0, 1, '2026-02-16 09:26:42', ''),
(2, 'User2', 'user2@example.com', '$2y$10$kwzVAIBcDyrB7Qz8645mSucLT.8V8sz7rwFI8jnQB.WrAEb9XtFfu', 0, 1, '2026-02-16 09:26:42', ''),
(3, 'OscarHueso', 'oscarHueso@gmail.com', '$2y$10$BVo.Ixn5RW.y/C/clPp3A.mc86WY2IvnYMbQm.VezTDInIpL8.Vfi', 0, 1, '2026-02-16 09:26:42', ''),
(4, 'Ahmad', 'ahmad@gmail.com', '1234', 0, 1, '2026-02-16 09:26:42', ''),
(5, 'jaime', 'jaimeacicuendez@gmail.com', '1234', 0, 0, '2026-02-17 22:26:42', '6a7d9ff9c449cb9ac329830052a26ef8dad6336f5f80db190ea79d9cdb308b88');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`idComentario`),
  ADD KEY `idPost` (`idPost`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`idPost`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `seguidores`
--
ALTER TABLE `seguidores`
  ADD PRIMARY KEY (`idSeguidor`,`idSeguido`),
  ADD KEY `idSeguido` (`idSeguido`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `idComentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `idPost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`idPost`) REFERENCES `posts` (`idPost`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `seguidores`
--
ALTER TABLE `seguidores`
  ADD CONSTRAINT `seguidores_ibfk_1` FOREIGN KEY (`idSeguidor`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `seguidores_ibfk_2` FOREIGN KEY (`idSeguido`) REFERENCES `usuarios` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
