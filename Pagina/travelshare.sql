-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-06-2018 a las 13:57:36
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `travelshare`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enlace`
--

CREATE TABLE `enlace` (
  `id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  `vehiculos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `enlace`
--

INSERT INTO `enlace` (`id`, `usuarios_id`, `vehiculos_id`) VALUES
(27, 3, 37),
(29, 2, 38),
(30, 2, 37),
(36, 5, 44);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombreusuario` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `telefono` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombreusuario`, `email`, `password`, `nombre`, `fecha`, `telefono`) VALUES
(2, 'glucap', 'lucap@hotmail.com', '25491a7c7420a7386bb45a3fb1b289af', 'Gianluca Piriz', '1992-11-30', '421901'),
(3, 'camilab', 'camilab@hotmail.com', '25491a7c7420a7386bb45a3fb1b289af', 'Camila Bolo', '1998-05-30', '12489'),
(4, 'brianb', 'brianb@hotmail.com', '25491a7c7420a7386bb45a3fb1b289af', 'Brian Blanco', '1994-05-31', '124992'),
(5, 'BigBossTheSnake', 'brai_ladoce@hotmail.com', 'c6f2b3d53f147238629b039187b5363e', 'bigboss', '1995-04-24', '412029'),
(6, 'Robertooo', 'qwe@qwe.com', 'd5538651cfc90611853eb0d45dcf102b', 'nadaaaaaa', '1992-06-16', '1240912');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL,
  `plazas` int(11) NOT NULL,
  `marca` varchar(20) NOT NULL,
  `modelo` varchar(20) NOT NULL,
  `color` varchar(20) NOT NULL,
  `patente` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `plazas`, `marca`, `modelo`, `color`, `patente`) VALUES
(37, 4, 'Chevrolet', 'Corsa', 'Azul', 'asd123'),
(38, 2, 'Ford', 'F100', 'Verde', 'aca123'),
(44, 5, 'Toyota', 'Supra', 'Verde', 'zzz124');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viajes`
--

CREATE TABLE `viajes` (
  `id` int(11) NOT NULL,
  `preciototal` double NOT NULL,
  `origen` varchar(100) NOT NULL,
  `destino` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `duracion` time NOT NULL,
  `plazas` int(11) NOT NULL,
  `vehiculos_id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `viajes`
--

INSERT INTO `viajes` (`id`, `preciototal`, `origen`, `destino`, `fecha`, `duracion`, `plazas`, `vehiculos_id`, `usuarios_id`, `telefono`, `email`) VALUES
(6, 120, 'Posadas', 'Corrientes', '2018-08-29', '03:00:00', 4, 37, 3, '4812020', 'b@hotmail.com'),
(7, 123, 'La Plata', 'CABA', '2018-07-06', '01:00:00', 4, 37, 2, '4227898', 'h@hotmail.com'),
(10, 123, 'La Plata', 'Corrientes', '2018-07-07', '03:00:00', 3, 37, 2, '4287985', 'jose@hotmail.com'),
(11, 123, 'Moscu', 'La quiaca', '2018-06-29', '22:22:00', 3, 37, 2, '2214569878', 'jorga@hotmail.com'),
(12, 1200, 'abasto', 'shopping', '2020-04-20', '03:20:00', 3, 44, 5, '159874564', 'brai_ladoce@hotmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `enlace`
--
ALTER TABLE `enlace`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `viajes`
--
ALTER TABLE `viajes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `enlace`
--
ALTER TABLE `enlace`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `viajes`
--
ALTER TABLE `viajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
