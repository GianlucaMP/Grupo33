-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-06-2018 a las 21:42:56
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
(31, 5, 39);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasajeros`
--

CREATE TABLE `pasajeros` (
  `id` int(11) NOT NULL,
  `viajes_id` int(11) NOT NULL,
  `pasajeros_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulaciones`
--

CREATE TABLE `postulaciones` (
  `id` int(11) NOT NULL,
  `viajes_id` int(11) NOT NULL,
  `postulados_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `postulaciones`
--

INSERT INTO `postulaciones` (`id`, `viajes_id`, `postulados_id`) VALUES
(1, 14, 2),
(2, 14, 2),
(3, 14, 2);

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
(2, 'glucap', 'lucap@hotmail.com', '25491a7c7420a7386bb45a3fb1b289af', 'Gianluca Piriz', '1992-11-30', '222'),
(3, 'camilab', 'camilab@hotmail.com', '25491a7c7420a7386bb45a3fb1b289af', 'Camila Bolo', '1998-05-30', '222'),
(4, 'brianb', 'brianb@hotmail.com', '25491a7c7420a7386bb45a3fb1b289af', 'Brian Blanco', '1994-05-31', '222'),
(5, 'BigBossTheSnake', 'brai_ladoce@hotmail.com', 'c6f2b3d53f147238629b039187b5363e', 'bigboss', '1995-04-24', '222'),
(6, 'Robertooo', 'qwe@qwe.com', 'd5538651cfc90611853eb0d45dcf102b', 'nadaaaaaa', '1992-06-16', '222'),
(7, 'pepito', 'calumaster@hotmail.com', '25491a7c7420a7386bb45a3fb1b289af', 'Peter Alfonso', '1990-06-06', '2213456789');

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
(39, 2, 'Toyota', 'Hilux', 'Verde', 'ddd222');

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
  `contacto` varchar(100) NOT NULL,
  `usuarios_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `viajes`
--

INSERT INTO `viajes` (`id`, `preciototal`, `origen`, `destino`, `fecha`, `duracion`, `plazas`, `vehiculos_id`, `contacto`, `usuarios_id`) VALUES
(6, 120, 'Posadas', 'Corrientes', '2018-08-29', '03:00:00', 4, 37, 'camilab@hotmail.com', 3),
(7, 123, 'La Plata', 'CABA', '2018-07-06', '01:00:00', 4, 37, 'lucap@hotmail.com', 2),
(10, 123, 'La Plata', 'Corrientes', '2018-07-07', '03:00:00', 3, 37, 'lucap@hotmail.com', 2),
(12, 200, 'Posadas', 'Iguazu', '2018-07-07', '10:15:00', 2, 38, 'lucap@hotmail.com', 2),
(13, 300, 'Resistencia', 'Parana', '2018-07-06', '22:00:00', 2, 37, 'lucap@hotmail.com', 2),
(14, 100, 'Posadas', 'Apostoles', '2018-07-07', '12:00:00', 3, 37, 'camilab@hotmail.com', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viajes_finalizados`
--

CREATE TABLE `viajes_finalizados` (
  `id` int(11) NOT NULL,
  `destino` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `duracion` time NOT NULL,
  `origen` varchar(100) NOT NULL,
  `plazas` int(11) NOT NULL,
  `preciototal` double NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  `vehiculos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `viajes_finalizados`
--

INSERT INTO `viajes_finalizados` (`id`, `destino`, `fecha`, `duracion`, `origen`, `plazas`, `preciototal`, `usuarios_id`, `vehiculos_id`) VALUES
(1, 'Merlo', '2020-11-20', '20:22:00', 'Suiza', 1, 1200, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `enlace`
--
ALTER TABLE `enlace`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pasajeros`
--
ALTER TABLE `pasajeros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
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
-- Indices de la tabla `viajes_finalizados`
--
ALTER TABLE `viajes_finalizados`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `enlace`
--
ALTER TABLE `enlace`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `pasajeros`
--
ALTER TABLE `pasajeros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `viajes`
--
ALTER TABLE `viajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `viajes_finalizados`
--
ALTER TABLE `viajes_finalizados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
