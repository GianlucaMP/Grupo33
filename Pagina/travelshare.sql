-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-07-2018 a las 19:14:06
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
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id` int(11) NOT NULL,
  `viaje_id` int(11) NOT NULL,
  `calificador_id` int(11) NOT NULL,
  `calificado_id` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `puntaje` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enlace`
--

CREATE TABLE `enlace` (
  `id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  `vehiculos_id` int(11) NOT NULL,
  `eliminado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `enlace`
--

INSERT INTO `enlace` (`id`, `usuarios_id`, `vehiculos_id`, `eliminado`) VALUES
(27, 3, 37, 'N'),
(29, 2, 38, 'N'),
(30, 2, 37, 'N'),
(35, 5, 43, 'N'),
(36, 5, 44, 'N'),
(37, 5, 45, 'N');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  `viajes_id` int(11) NOT NULL,
  `pago` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `usuarios_id`, `viajes_id`, `pago`) VALUES
(1, 5, 51, 'T'),
(4, 5, 54, 'F');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulaciones`
--

CREATE TABLE `postulaciones` (
  `id` int(11) NOT NULL,
  `viajes_id` int(11) NOT NULL,
  `postulados_id` int(11) NOT NULL,
  `estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `postulaciones`
--

INSERT INTO `postulaciones` (`id`, `viajes_id`, `postulados_id`, `estado`) VALUES
(1, 14, 2, 'P'),
(2, 14, 2, 'P'),
(3, 14, 2, 'P'),
(6, 6, 5, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `viajes_id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  `pregunta` varchar(100) NOT NULL,
  `numero_pregunta` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `telefono` varchar(30) NOT NULL,
  `eliminado` char(1) NOT NULL,
  `calificacion` int(11) NOT NULL,
	`cantidad_votos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombreusuario`, `email`, `password`, `nombre`, `fecha`, `telefono`, `eliminado`) VALUES
(2, 'glucap', 'lucap@hotmail.com', '25491a7c7420a7386bb45a3fb1b289af', 'Gianluca Piriz', '1992-11-30', '15665', 'N'),
(3, 'camilab', 'camilab@hotmail.com', '25491a7c7420a7386bb45a3fb1b289af', 'Camila Bolo', '1998-05-30', '4564898', 'N'),
(4, 'brianb', 'brianb@hotmail.com', '25491a7c7420a7386bb45a3fb1b289af', 'Brian Blanco', '1994-05-31', '894984', 'N'),
(5, 'BigBossTheSnake', 'brai_ladoce@hotmail.com', 'c6f2b3d53f147238629b039187b5363e', 'bigboss', '1995-04-24', '4230564', 'N'),
(6, 'Robertooo', 'qwe@qwe.com', 'd5538651cfc90611853eb0d45dcf102b', 'nadaaaaaa', '1992-06-16', '48948', 'N'),
(7, 'pepito', 'calumaster@hotmail.com', '25491a7c7420a7386bb45a3fb1b289af', 'Peter Alfonso', '1990-06-06', '2213456789', 'N'),
(8, 'Roberto', 'roberto@hotmail.com', 'c6f2b3d53f147238629b039187b5363e', 'Roberto Gomez Bolanos', '1930-12-20', '2214322520', 'N'),
(9, 'Robertito', 'robertito@hotmail.com', 'c6f2b3d53f147238629b039187b5363e', 'Robertito', '1940-12-20', '124121', 'N'),
(10, 'cachito', 'cachito@hotmail.com', 'c6f2b3d53f147238629b039187b5363e', 'cachito', '1940-12-20', '1325135', 'N'),
(11, 'Juancito', 'Juancito@hotmail.com', 'c6f2b3d53f147238629b039187b5363e', 'Juancho', '1930-12-20', '225135', 'N'),
(12, 'Andrecito', 'Andrecito@hotmail.com', 'c6f2b3d53f147238629b039187b5363e', 'Andrez Gomez', '1940-12-20', '1251212', 'N');

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
(43, 4, 'Toyota', 'Etios', 'Verde', 'qww-123'),
(44, 5, 'Mazda', 'rx7', 'Naranja', '125asg'),
(45, 8, 'Mazda', 'Rx8', 'Beige Angola', 'abc123');

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
  `horario` time NOT NULL,
  `fechayhora` datetime NOT NULL,
  `duracion` time NOT NULL,
  `plazas` int(11) NOT NULL,
  `vehiculos_id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `viajes`
--

INSERT INTO `viajes` (`id`, `preciototal`, `origen`, `destino`, `fecha`, `horario`, `fechayhora`, `duracion`, `plazas`, `vehiculos_id`, `usuarios_id`) VALUES
(6, 120, 'Posadas', 'Corrientes', '2018-09-20', '00:00:00', '0000-00-00 00:00:00', '03:00:00', 4, 37, 3),
(7, 123, 'La Plata', 'CABA', '2018-07-20', '00:00:00', '0000-00-00 00:00:00', '01:00:00', 4, 37, 2),
(10, 123, 'La Plata', 'Corrientes', '2018-07-20', '00:00:00', '0000-00-00 00:00:00', '03:00:00', 3, 37, 2),
(12, 200, 'Posadas', 'Iguazu', '2018-09-13', '00:00:00', '0000-00-00 00:00:00', '10:15:00', 2, 38, 2),
(13, 300, 'Resistencia', 'Parana', '2018-07-20', '00:00:00', '0000-00-00 00:00:00', '22:00:00', 2, 37, 2),
(14, 100, 'Posadas', 'Apostoles', '2018-07-20', '00:00:00', '0000-00-00 00:00:00', '12:00:00', 3, 37, 3),
(47, 53252, 'Jujuy', 'Lanus', '2030-01-01', '05:21:00', '2030-01-01 05:21:00', '04:41:00', 2, 43, 5),
(51, 12412, 'Dolores', 'Cordoba', '2030-01-01', '02:10:00', '2030-01-01 02:10:00', '02:01:00', 3, 43, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viajes_finalizados`
--

CREATE TABLE `viajes_finalizados` (
  `id` int(11) NOT NULL,
  `preciototal` double NOT NULL,
  `origen` varchar(100) NOT NULL,
  `destino` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL,
  `duracion` time NOT NULL,
  `plazas` int(11) NOT NULL,
  `vehiculos_id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `viajes_finalizados`
--

INSERT INTO `viajes_finalizados` (`id`, `preciototal`, `origen`, `destino`, `fecha`, `duracion`, `plazas`, `vehiculos_id`, `usuarios_id`) VALUES
(2, 21421, 'Nigeria', 'Francia', '2018-12-20 00:00:00', '21:21:00', 3, 43, 5);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `enlace`
--
ALTER TABLE `enlace`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
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
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `enlace`
--
ALTER TABLE `enlace`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `viajes`
--
ALTER TABLE `viajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `viajes_finalizados`
--
ALTER TABLE `viajes_finalizados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
