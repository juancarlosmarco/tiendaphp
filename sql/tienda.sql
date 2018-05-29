-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-05-2018 a las 12:24:38
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idCat` int(11) NOT NULL,
  `nombreCat` varchar(25) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `descripcionCat` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `imagenCat` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `idImg` int(11) NOT NULL,
  `descripcionImg` text COLLATE utf8_spanish2_ci,
  `archivoImg` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `idPago` int(11) NOT NULL,
  `nombrePago` varchar(25) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `logo` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `fechaPedido` date NOT NULL,
  `cantidadPedido` int(11) NOT NULL,
  `idProd` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idPago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProd` int(11) NOT NULL,
  `nombreProd` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcionProd` text COLLATE utf8_spanish2_ci,
  `precioProd` double(5,2) NOT NULL,
  `unidadesProd` int(11) NOT NULL,
  `fechaAlta` date NOT NULL,
  `activado` bit(1) NOT NULL,
  `idCat` int(11) NOT NULL,
  `idImg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProd`, `nombreProd`, `descripcionProd`, `precioProd`, `unidadesProd`, `fechaAlta`, `activado`, `idCat`, `idImg`) VALUES
(3, 'La lista de Schildler 2', 'descripcion de la peli', 15.00, 7, '0000-00-00', b'0', 0, 0),
(4, 'vengadores 3', 'Peliculas de los vengadores', 150.00, 8, '0000-00-00', b'0', 0, 0),
(5, 'vengadores 2', 'pelicula de los vengadores', 56.00, 3, '0000-00-00', b'0', 0, 0),
(6, 'ant-man', 'pelicula de micro hormigas', 5.00, 3, '0000-00-00', b'0', 0, 0),
(7, 'lo que el viento se llevo', 'pelicula de clark ', 6.00, 87, '0000-00-00', b'0', 0, 0),
(8, 'y si no nos enfadamos', 'pelicula de bud spencer y terence hill', 60.00, 8, '0000-00-00', b'0', 0, 0),
(9, 'El codigo Da vinci', 'Pelicula sobre una trama policia de tal y cual....', 6.00, 7, '0000-00-00', b'0', 0, 0),
(10, 'Le llamaban trinidad', 'Gran pelicula del oeste', 7.00, 3, '0000-00-00', b'0', 0, 0),
(11, 'Venganza', 'Pelicula de Accion ambientada en un pais de moda', 8.00, 2, '0000-00-00', b'0', 0, 0),
(12, 'El cortador de cesped', 'Pelicula sobre realizad virtual', 6.00, 2, '0000-00-00', b'0', 0, 0),
(13, 'matrix', 'Pelicula sobre mundos de realidad virtual, pionera en su genero', 32.00, 21, '0000-00-00', b'0', 0, 0),
(14, 'El rey leon', 'Pelicula del año 1995 que cuenta la historia de ....', 15.00, 2, '0000-00-00', b'0', 0, 0),
(15, 'Curso 1999', 'Unos profesores, se cargan a sus alumnos porque si', 12.00, 45, '0000-00-00', b'0', 0, 0),
(16, 'Depredador', 'Pelicula sobre CHOCHENAGUER', 45.00, 2, '0000-00-00', b'0', 0, 0),
(17, 'Terminator', 'Pelicula sobre un cyborg del futuro, con desnudos incorporados', 23.00, 63, '0000-00-00', b'0', 0, 0),
(18, 'Terminator 2', 'Mas terminator que nunca', 45.00, 3, '0000-00-00', b'0', 0, 0),
(19, 'La habitacion de panico', 'Habitacion de seguridad en una mansion, donde hay un atraco, y nadie muere', 15.00, 21, '0000-00-00', b'0', 0, 0),
(20, 'Venganza 2', 'Mas venganza que la anterior, pero menos que la siguiente. Aqui muere hasta el apuntador.', 5.00, 6, '0000-00-00', b'0', 0, 0),
(21, 'Taxi', 'Pelicula de un taxista fitipaldi, que le gusta la velocidad mas que a un tonto un caramelo', 45.00, 3, '0000-00-00', b'0', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `login` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `correo` varchar(25) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `avatar` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `session` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombre`, `apellidos`, `login`, `password`, `correo`, `avatar`, `session`) VALUES
(1, 'david', 'fraj blesa', 'admin', 'ee10c315eba2c75b403ea99136f5b48d', 'admin@gmail.com', NULL, '4037a7a9c09c49d9532c09a2fca52f9f'),
(2, 'sergio', 'fraj blesa', 'sergiofraj', '81dc9bdb52d04dc20036dbd8313ed055', 'sergio@gmail.com', NULL, ''),
(3, 'esther', 'apellidos', 'esther', '81dc9bdb52d04dc20036dbd8313ed055', 'esther@gmail.com', NULL, ''),
(4, 'david', 'apellidos', 'david', '81dc9bdb52d04dc20036dbd8313ed055', 'david@gmail.com', NULL, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCat`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`idImg`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`idPago`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProd`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCat` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `idImg` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `idPago` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
