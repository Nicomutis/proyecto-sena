-- volcado SQL de phpMyAdmin
-- versión 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Hora de generación: 08 de sep de 2024 a las 01:47 PM
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Configuración de codificación de caracteres
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db`
--

-- --------------------------------------------------------

--
-- Estructura de la tabla `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(5) NOT NULL,
  `session_id` int(5) NOT NULL,
  `id_array` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `session_id`, `id_array`) VALUES
(1, 1, 'a:1:{i:0;s:1:"1";}');

-- --------------------------------------------------------

--
-- Estructura de la tabla `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `postTitle` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `auther` varchar(25) NOT NULL,
  `catinfo` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `postTitle`, `description`, `content`, `post_date`, `auther`, `catinfo`) VALUES
(6, 'Hello World!', 'Este es un post de ejemplo para SyncCircle. Un breve resumen de tu publicación de blog aquí.', '<h1 align="justify"><b>SyncCyrcle!</b><br></h1><p align="justify">&nbsp;¡Es increíble escribir una publicación de blog en tu propia plataforma de blogs!</p><p align="justify"> Blogging es una de las características de SyncCircle. El SyncCircle&nbsp; puede hacer muchas cosas.</p><p align="justify"><b>Características de SyncCircle -</b></p><div align="justify"><ul><li><b>Hermoso Panel de Control</b></li><li><b>Gestión de Miembros (para Administradores)</b></li><li><b>Plataforma de Blogging (para Administradores y Miembros) </b></li><li><b>Tablero de Anuncios (para Notificaciones y Anuncios del Club)</b></li><li><b>Eventos y Sesiones Programadas</b></li><li><b>Asistencia para Sesiones</b></li></ul></div><p align="justify"><b><br>más características en el futuro</b></p><p align="justify"><br></p>', '2024-09-08 11:46:10', 'admin', 'Tecnología');

-- --------------------------------------------------------

--
-- Estructura de la tabla `notice`
--

CREATE TABLE `notice` (
  `notice_id` int(5) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `date` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `notice`
--

INSERT INTO `notice` (`notice_id`, `title`, `description`, `date`) VALUES
(2, 'Este es el Título de una notica de Ejemplo', 'Descripción del aviso en 250 caracteres. Explica todos los detalles del aviso en esta sección. ', '08-09-2024 16:51');

-- --------------------------------------------------------

--
-- Estructura de la tabla `sessions`
--

CREATE TABLE `sessions` (
  `session_id` int(5) NOT NULL,
  `session_name` varchar(150) NOT NULL,
  `session_details` varchar(250) NOT NULL,
  `session_date` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`session_id`, `session_name`, `session_details`, `session_date`) VALUES
(1, 'Título del Nuevo Evento Aquí', 'Descripción del evento va aquí. Explica todo sobre tu evento aquí. ', '08-09-2024 16:53');

-- --------------------------------------------------------

--
-- Estructura de la tabla `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(70) DEFAULT NULL,
  `dob` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` text NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `last_login` datetime NOT NULL,
  `currunt_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `otp` varchar(10) NOT NULL,
  `pic` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `userinfo`
--

INSERT INTO `userinfo` (`id`, `name`, `email`, `dob`, `username`, `password`, `role`, `last_login`, `currunt_login`, `otp`, `pic`) VALUES
(1, 'Admin', 'admin@gmail.com', '12', 'admin', '12345', 'President', '2024-09-07 23:32:55', '2024-09-08 10:43:59', '389531', 'imgs/17241-200.png'),
(2, 'Miembro', 'member', '11', 'member', 'member', 'Miembro', '2024-09-06 23:22:26', '2024-09-06 17:52:52', '', NULL);

--
-- Índices para las tablas volcada
--

--
-- Índices para la tabla `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Índices para la tabla `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Índices para la tabla `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`notice_id`);

--
-- Índices para la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Índices para la tabla `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para las tablas volcada
--

--
-- AUTO_INCREMENT para la tabla `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT para la tabla `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT para la tabla `notice`
--
ALTER TABLE `notice`
  MODIFY `notice_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT para la tabla `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT para la tabla `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
