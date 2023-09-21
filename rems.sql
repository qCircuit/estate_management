-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 21, 2023 at 07:15 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rems`
--

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `property_name` varchar(200) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `property_name`, `description`, `img`, `created_by`, `created_at`, `updated_at`) VALUES
(10, 'Apartamento en Calpe, ID S11958', 'Apartamento en venta en segunda linea de la playa Arenal Bol en Calpe, Costa Blanca. Amplio y soleado apartamento con un salon comedor con acceso a la gran terraza acristalada, cocina independiente con galería, 2 dormitorios, 2 baños, parking privado. La vivienda se encuentra en un edificio muy céntrico a 30m de la playa Arenal Bol. El edificio dispone de zona ajardinada con una gran piscina.​', 'S11967.jpg', 1, '2023-07-24 22:11:19', '2023-07-24 22:11:19'),
(12, 'Apartamento en Calpe, ID S11969', 'Alquiler anual a partir de noviembre. Acojedor apartamento con amplia terraza y imprecionantes vistas al mar, en la primera linea de la playa Levante en Calpe. Es un apartamento muy soleado, completamente amueblado y equipado, tiene un salon comedor, un dormitorio, cocina americana y una amplia terrasa.    ', 'property-1690452464.jpg', 1, '2023-07-26 11:37:43', '2023-07-26 11:37:43'),
(26, 'IDP4138', 'Se trata de una villa con dos apartamentos. uno de los apartamentos consta de un hall de entrada, un salón comedor con chimenea y salida hacia una terraza cerrada, una cocina independiente e totalmente equipada. Tambien cuenta de dos dormitorios y uno de los dormitorios tipo suite.', 'property-1691518526.jpeg', 1, '2023-08-08 20:15:26', '2023-08-08 20:15:26'),
(28, 'IDP3441', 'Precioso apartamento de 2 dormitorios, 2 baños, salón-comedor, cocina, lavadero.\r\nConsta de habitaciones amplias con materiales de calidad.', 'property-1691523385.jpg', 1, '2023-08-08 21:36:25', '2023-08-08 21:36:25'),
(31, 'Appartement en Calpe, ID P8724', 'Consta de una habitación, un cuartos de baño, una cocina americana con su salón/comedor y una bonita terraza donde se puede apreciar la Playa de Levante y el majestuoso Peñón de Ifach!', 'property-1691570536.jpeg', 1, '2023-08-09 10:42:16', '2023-08-09 10:42:16'),
(32, 'Apartamento en Calpe, ID P8250', 'Se vende atico de 314 m2 con 4 dormitorios en primera línea de la playa Levante (La Fossa) en Calpe. Se trata de un ático que dispone de una planta entera. ', 'property-1691571332.jpeg', 1, '2023-08-09 10:55:32', '2023-08-09 10:55:32'),
(33, 'Villa en Calpe, ID S7617', 'Preciosos bungalows en venta con espectaculares vistas al mar y a las montañas. Cada uno tiene una superficie de 330m² cada uno en una parcela de 550m².', 'property-1691572705.jpg', 1, '2023-08-09 11:18:25', '2023-08-09 11:18:25'),
(34, 'Villa en Calpe, ID P3280', 'Casa grande y elegante con 6 dormitorios cerca de la ciudad y la playa con un hermoso jardín: un oasis de paz.', 'property-1691573565.jpg', 1, '2023-08-09 11:32:45', '2023-08-09 11:32:45'),
(35, 'Apartamento en Calpe, ID S9575', 'Este acogedor apartamento situado cerca de una de las playas más privilegiadas de Calpe cuenta con una superficie total de 101 metros cuadrados.', 'property-1691575595.jpg', 1, '2023-08-09 12:06:35', '2023-08-09 12:06:35');

-- --------------------------------------------------------

--
-- Table structure for table `propertytenants`
--

CREATE TABLE `propertytenants` (
  `id` int(11) NOT NULL,
  `tenant` int(11) NOT NULL,
  `property` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `propertytenants`
--

INSERT INTO `propertytenants` (`id`, `tenant`, `property`, `created_at`, `updated_at`) VALUES
(9, 2, 26, '2023-08-08 20:15:26', '2023-08-08 20:15:26'),
(11, 4, 28, '2023-08-08 21:36:25', '2023-08-08 21:36:25'),
(14, 10, 31, '2023-08-09 10:42:17', '2023-08-09 10:42:17'),
(15, 11, 32, '2023-08-09 10:55:32', '2023-08-09 10:55:32'),
(16, 12, 33, '2023-08-09 11:18:25', '2023-08-09 11:18:25'),
(17, 13, 34, '2023-08-09 11:32:45', '2023-08-09 11:32:45'),
(18, 14, 35, '2023-08-09 12:06:35', '2023-08-09 12:06:35');

-- --------------------------------------------------------

--
-- Table structure for table `property_tenant`
--

CREATE TABLE `property_tenant` (
  `id` int(11) NOT NULL,
  `tenant` int(11) DEFAULT NULL,
  `property` int(11) DEFAULT NULL,
  `rent_start` datetime DEFAULT NULL,
  `rent_end` datetime DEFAULT NULL,
  `payment_status` varchar(30) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` int(11) NOT NULL,
  `tenant_name` varchar(200) NOT NULL,
  `tenant_phone` varchar(200) NOT NULL,
  `tenant_email` varchar(200) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `tenant_name`, `tenant_phone`, `tenant_email`, `created_by`, `created_at`, `updated_at`) VALUES
(2, 'Jose Maura', '100298128', 'jose@gmail.com', 1, '2023-07-28 11:20:05', '2023-07-28 11:20:05'),
(4, 'Sara Vega', '209829211', 'saravega@rems.com', 1, '2023-07-31 12:18:09', '2023-07-31 12:18:09'),
(10, 'Erik Zamorano', '819234178', 'erik@mail.com', 1, '2023-08-09 10:34:36', '2023-08-09 10:34:36'),
(11, 'Teo Texlido', '241912354', 'teo@mail.com', 1, '2023-08-09 10:35:10', '2023-08-09 10:35:10'),
(12, 'Gema Bescas', '918293123', 'gema@mail.com', 1, '2023-08-09 10:56:27', '2023-08-09 10:56:27'),
(13, 'Vega Sallent', '739212038', 'vega@mail.com', 1, '2023-08-09 10:56:45', '2023-08-09 10:56:45'),
(14, 'Tania Martines', '234312329', 'tania@mail.com', 1, '2023-08-09 10:57:22', '2023-08-09 10:57:22'),
(15, 'test2', '12345909', 'test@mail.com', 1, '2023-09-21 11:56:35', '2023-09-21 11:56:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(300) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Carla', 'Vergara', '123', 'carlavergara@rems.com', '2023-07-14 15:42:15', '2023-07-14 15:42:15'),
(21, 'Julio', 'Sanchez', '$2y$10$MTpeJNYFYDdm4x3DIpY.AeAdcVDqX/SnMvp/vK.RKAMCN89Bqx6BC', 'juliosanch@rems.com', '2023-07-23 15:41:42', '2023-07-23 16:15:03'),
(22, 'Javier', 'Casas', '12345', 'javier@rems.com', '2023-07-24 12:31:54', '2023-07-24 12:31:54'),
(25, 'Leticia', 'Oreiro', '$2y$10$n78neZ3cRmJ14Zolydwjce2BwiQrdsUnBm85fCkIDPVSDcIWgyeuy', 'leticia@rems.com', '2023-07-24 12:38:45', '2023-07-24 12:38:45'),
(29, 'Abril', 'Ferreira', '$2y$10$nXwW4A2QUa0GzpaJYpqV0.YoqJa/8Vz4LgULnlTdAr2FV7hO/u9kG', 'abril@mail.com', '2023-08-09 11:25:58', '2023-08-09 11:25:58'),
(31, 'test2', 'test23', '$2y$10$c6ML8Nu4xkAzGf5M8EWn4OvYZCDaJ3knFlmXOtAsUqLP6gvSaCAxy', 'test2@rems.com', '2023-09-21 15:14:05', '2023-09-21 15:15:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`created_by`);

--
-- Indexes for table `propertytenants`
--
ALTER TABLE `propertytenants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property` (`property`),
  ADD KEY `tenant` (`tenant`);

--
-- Indexes for table `property_tenant`
--
ALTER TABLE `property_tenant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant` (`tenant`),
  ADD KEY `property` (`property`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `propertytenants`
--
ALTER TABLE `propertytenants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `propertytenants`
--
ALTER TABLE `propertytenants`
  ADD CONSTRAINT `propertytenants_ibfk_1` FOREIGN KEY (`property`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `propertytenants_ibfk_2` FOREIGN KEY (`tenant`) REFERENCES `tenants` (`id`);

--
-- Constraints for table `property_tenant`
--
ALTER TABLE `property_tenant`
  ADD CONSTRAINT `property_tenant_ibfk_1` FOREIGN KEY (`tenant`) REFERENCES `tenants` (`id`),
  ADD CONSTRAINT `property_tenant_ibfk_2` FOREIGN KEY (`property`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `property_tenant_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `rate_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);

--
-- Constraints for table `tenants`
--
ALTER TABLE `tenants`
  ADD CONSTRAINT `fk_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
