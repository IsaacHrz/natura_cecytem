-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2025 a las 15:31:04
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
-- Base de datos: `natura_cecytem`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `nombre_usuario` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comentario` text NOT NULL,
  `valoracion` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `aprobado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `producto_id`, `nombre_usuario`, `email`, `comentario`, `valoracion`, `fecha`, `aprobado`) VALUES
(1, 1, 'Isaac Josue Hernandez Reyes ', 'camacho@gmail.com', 'Muy bueno el producto', 5, '2025-05-19 11:44:20', 0),
(2, 1, 'Isaac Josue Hernandez Reyes ', 'camacho@gmail.com', 'Muy bueno el producto', 5, '2025-05-19 11:44:26', 0),
(3, 1, 'Isaac Josue 2', 'prueba@gmail.com', 'Muy bueno el producto', 5, '2025-05-19 12:37:47', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `categoria`, `stock`, `fecha_creacion`) VALUES
(1, 'Gel Antibacterial', 'Gel antibacterial elaborado con ingredientes naturales que elimina el 99.9% de bacterias sin dañar tu piel.', 49.99, 'img/gel.jpg', 'Higiene', 15, '2025-05-13 18:31:09'),
(2, 'Crema Corporal', 'Crema hidratante corporal con ingredientes naturales que nutren y protegen tu piel.', 59.99, 'img/crema.jpg', 'Cuidado Personal', 8, '2025-05-13 18:31:09'),
(3, 'Ungüento Medicinal', 'Alivio natural para dolores y heridas. Ideal para torceduras, dolores musculares y pequeñas irritaciones de la piel.', 39.99, 'img/unguento.jpg', 'Salud', 12, '2025-05-13 18:31:09'),
(4, 'Acetona Natural', 'Removedor de esmalte suave y ecológico. Elimina el esmalte sin dañar ni resecar tus uñas.', 59.99, 'img/acetona.jpg', 'Belleza', 5, '2025-05-13 18:31:09'),
(5, 'Loción Desmaquillante', 'Limpieza facial suave y natural. Elimina el maquillaje incluso el resistente al agua, sin irritar la piel.', 79.99, 'img/locion.jpg', 'Belleza', 0, '2025-05-13 18:31:09'),
(6, 'Labial Natural', 'Color y cuidado para tus labios. Hidrata mientras proporciona un toque de color natural.', 45.99, 'img/labial.jpg', 'Belleza', 20, '2025-05-13 18:31:09');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
