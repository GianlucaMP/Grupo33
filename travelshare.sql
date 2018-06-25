-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-06-2018 a las 22:08:06
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
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombreusuario` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombreusuario`, `email`, `password`, `nombre`, `fecha`, `telefono`) VALUES
(2, 'Roberto', 'q@w.com', '25491a7c7420a7386bb45a3fb1b289af', 'Roberto Carlos Gardel', '1992-11-30', '2214579988'),
(3, 'Andres', 'andres@gmail.com', 'c6f2b3d53f147238629b039187b5363e', 'Andrecito', '1995-04-24', '21345547898'),
(4, 'BigBossTheSnake', 'brai_ladoce@hotmail.com', 'c6f2b3d53f147238629b039187b5363e', 'braian', '1995-04-23', '2214549898'),
(12, 'alfredo', 'alfredo@hotmail.com', 'c6f2b3d53f147238629b039187b5363e', 'alfredo', '1995-02-21', '2214401211'),
(13, 'anibal', 'anibal@hotmail.com', 'c6f2b3d53f147238629b039187b5363e', 'anibal', '1995-09-12', '2215193'),
(14, 'Carlitos', 'carlitos@hotmail.com', 'c6f2b3d53f147238629b039187b5363e', 'Carlitos', '1995-10-24', '444022324');

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
  `patente` varchar(7) NOT NULL,
  `usuarios_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `plazas`, `marca`, `modelo`, `color`, `patente`, `usuarios_id`) VALUES
(2, 4, 'Chevrolet', 'Corsa', 'Blanco', 'asd124', 2),
(4, 4, 'Toyota', 'Etios', 'Beige Angola', 'ada', 3),
(6, 5, 'toyota', 'supra', 'blanco', 'abc124', 4);

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
  `vehiculo` varchar(100) NOT NULL,
  `contacto` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `conductor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `viajes`
--

INSERT INTO `viajes` (`id`, `preciototal`, `origen`, `destino`, `fecha`, `vehiculo`, `contacto`, `email`, `telefono`, `conductor`) VALUES
(1, 120, 'La Plata', 'Tandil', '2018-05-28', 'Toyota Corolla', 'Sr Pedro\r\nNro: 221 3445677', '', '', 0),
(2, 350, 'Abasto', 'Centro', '2018-07-22', 'Honda 110 Biz', 'Sr John\r\n221 2334678', '', '', 0),
(3, 555, 'CABA', 'Cordoba', '2018-06-02', 'Peugeot 206', 'Sr Titor\r\n011 32412398', '', '', 0),
(5, 1240, 'Avellaneda', 'Villa 31', '2099-12-20', '6', '', '', '', 4);

--
-- Índices para tablas volcadas
--

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
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `viajes`
--
ALTER TABLE `viajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
