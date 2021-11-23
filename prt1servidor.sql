-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2021 a las 13:22:11
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prt1servidor`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosusuario`
--

CREATE TABLE `datosusuario` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_alta` date NOT NULL,
  `num_vehiculos` int(11) NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `datosusuario`
--

INSERT INTO `datosusuario` (`idUsuario`, `nombre`, `login`, `fecha_alta`, `num_vehiculos`, `password`, `admin`) VALUES
(12, 'jesus', 'jesusito', '2021-11-09', 2, '$2y$10$mQ43VHWpW9J0NuVekKfI3uFNe5sjwaCFsudxr8BBWugizvQsjjbGi', 0),
(13, 'alberto', 'troya', '2021-11-10', 0, '$2y$10$PN8bvmJmUZl2v8bAQZH4heZ7n5/u9zmVNmdGSnAEr29RX55Fib5t.', 0),
(14, 'edu', 'admin1', '2021-11-10', 0, '$2y$10$GGG3MzKJ05TsXiWE6ey3I.yFm0agNG0Sb7bHMkhLyUE9YbWreVWRC', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listaservicios`
--

CREATE TABLE `listaservicios` (
  `idServicio` int(11) NOT NULL,
  `idVehiculo` int(11) NOT NULL,
  `Averia_motor` date NOT NULL,
  `Pinchazo` date NOT NULL,
  `Cambio_aceite` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `listaservicios`
--

INSERT INTO `listaservicios` (`idServicio`, `idVehiculo`, `Averia_motor`, `Pinchazo`, `Cambio_aceite`) VALUES
(8, 152, '2021-11-25', '2021-11-25', '2021-11-11'),
(9, 153, '2021-12-03', '2021-11-13', '2021-11-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listavehiculo`
--

CREATE TABLE `listavehiculo` (
  `idUsuario` int(11) NOT NULL,
  `idVehiculo` int(11) NOT NULL,
  `Marca` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Matricula` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Modelo` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `listavehiculo`
--

INSERT INTO `listavehiculo` (`idUsuario`, `idVehiculo`, `Marca`, `Matricula`, `Modelo`) VALUES
(12, 152, 'No', '0000XXX', 'Si'),
(12, 153, 'Ford', '0000XXX', 'Mustang');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `datosusuario`
--
ALTER TABLE `datosusuario`
  ADD PRIMARY KEY (`idUsuario`) USING BTREE;

--
-- Indices de la tabla `listaservicios`
--
ALTER TABLE `listaservicios`
  ADD PRIMARY KEY (`idServicio`),
  ADD KEY `fk_foreign_idVehiculo` (`idVehiculo`);

--
-- Indices de la tabla `listavehiculo`
--
ALTER TABLE `listavehiculo`
  ADD PRIMARY KEY (`idVehiculo`),
  ADD KEY `fk_foreign_idUsuario` (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `datosusuario`
--
ALTER TABLE `datosusuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `listaservicios`
--
ALTER TABLE `listaservicios`
  MODIFY `idServicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `listavehiculo`
--
ALTER TABLE `listavehiculo`
  MODIFY `idVehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `listaservicios`
--
ALTER TABLE `listaservicios`
  ADD CONSTRAINT `fk_foreign_idVehiculo` FOREIGN KEY (`idVehiculo`) REFERENCES `listavehiculo` (`idVehiculo`);

--
-- Filtros para la tabla `listavehiculo`
--
ALTER TABLE `listavehiculo`
  ADD CONSTRAINT `fk_foreign_idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `datosusuario` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
