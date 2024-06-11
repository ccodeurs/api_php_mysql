-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2024 a las 02:19:52
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
-- Base de datos: `api_restaurante`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `token` text DEFAULT NULL,
  `is_confirm` tinyint(1) DEFAULT 0,
  `image` varchar(200) DEFAULT NULL,
  `rol` enum('user','admin','super_admin') NOT NULL DEFAULT 'user',
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `token`, `is_confirm`, `image`, `rol`, `status`, `created_at`, `updated_at`) VALUES
(7, 'ismaila mama', 'kaba drame', 'ismaila12@gmail.ess', '$2y$10$YI9iE0p7Q.SV20/7sgd06enVkk0QRzRTr.hXS0lMyMCXkxT4JjClW', NULL, 0, 'upload/img/users/66659c19eee2bCatura.PNG', 'user', 2, '2024-06-09 01:29:23', '2024-06-09 01:29:23'),
(8, 'ismaila', 'kaba', 'ismaila11@gmail.es', '$2y$10$h7TmEE3fzZBf.N48rtzkwujjEHySiahro5J9bOYl7PxlDTOTZ6P36', NULL, 0, 'upload/img/users/666597599ab1cismaila2.png', 'user', 1, '2024-06-09 03:25:24', '2024-06-09 03:25:24'),
(9, 'ismaila', 'kaba', 'ismaila112@gmail.es', '$2y$10$651E04chKDViAshboOhpDOlWUo3h5/iyAo5JjJBcZLFEYvD8SBocW', NULL, 0, 'upload/img/users/666589763f27101.jpg', 'user', 1, '2024-06-09 10:52:38', '2024-06-09 10:52:38'),
(10, 'ismaila', 'kaba', 'ismaila112@gmail.com', '$2y$10$uacuUwpRN2U482RLCSnojOoM4FcUnvG1uv9yi39nILMQkU5xddzF2', NULL, 0, 'upload/img/users/6665931f60cb5Cacahute-polvo-desgrasado-Justloading-transparente-1.png', 'user', 1, '2024-06-09 11:33:51', '2024-06-09 11:33:51');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
