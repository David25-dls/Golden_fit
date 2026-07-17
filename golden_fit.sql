-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2026 a las 03:24:04
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `golden_fit`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `ID_categoria` int(11) NOT NULL,
  `Nombre_categoria` varchar(100) NOT NULL,
  `Descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`ID_categoria`, `Nombre_categoria`, `Descripcion`) VALUES
(1, 'Polos', 'Camisetas y polos de diversas marcas'),
(2, 'Pantalones', 'Jeans, joggers y pantalones formales'),
(3, 'Zapatillas', 'Calzado deportivo y casual'),
(4, 'Casacas', 'Chaquetas y casacas para toda ocasion'),
(5, 'Shorts', 'Shorts deportivos y casuales'),
(6, 'Vestidos', 'Vestidos casuales y de fiesta'),
(7, 'Camisas', 'Camisas formales e informales'),
(8, 'Buzos', 'Buzos y ropa deportiva'),
(9, 'Accesorios', 'Gorras, cinturones y billeteras'),
(10, 'Ropa Interior', 'Ropa interior de hombre y mujer');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ID_cliente` int(11) NOT NULL,
  `Nombre_cliente` varchar(100) NOT NULL,
  `Direccion` varchar(100) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Telefono` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID_cliente`, `Nombre_cliente`, `Direccion`, `Correo`, `Telefono`) VALUES
(1, 'Carlos Ramirez', 'Av. Lima 123, Piura', 'carlos@gmail.com', '987654321'),
(2, 'Maria Torres', 'Jr. Piura 456, Lima', 'maria@gmail.com', '912345678'),
(3, 'Luis Gutierrez', 'Calle Arequipa 7, Trujillo', 'luis@gmail.com', '956789012'),
(4, 'Ana Flores', 'Av. Grau 89, Chiclayo', 'ana@gmail.com', '943210987'),
(5, 'Jorge Mendoza', 'Jr. Tacna 234, Piura', 'jorge@gmail.com', '978563412'),
(6, 'Rosa Castillo', 'Av. Loreto 567, Iquitos', 'rosa@gmail.com', '965432109'),
(7, 'Pedro Salinas', 'Calle Cusco 12, Arequipa', 'pedro@gmail.com', '934567890'),
(8, 'Lucia Vargas', 'Jr. Ancash 678, Lima', 'lucia@gmail.com', '921098765'),
(9, 'Miguel Quispe', 'Av. Puno 345, Juliaca', 'miguel@gmail.com', '967891234'),
(10, 'Sofia Huaman', 'Calle Junin 90, Huancayo', 'sofia@gmail.com', '954321678'),
(13, 'David Pacherres Lázaro', 'Calle. Leoncion Prado, Cruceta', 'David@gmail.com', '928972238');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `ID_detalle` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Precio_unitario` decimal(10,2) NOT NULL,
  `Subtotal` decimal(10,2) NOT NULL,
  `VENTA_ID_venta` int(11) NOT NULL,
  `PRODUCTO_ID_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`ID_detalle`, `Cantidad`, `Precio_unitario`, `Subtotal`, `VENTA_ID_venta`, `PRODUCTO_ID_producto`) VALUES
(1, 1, 45.00, 45.00, 1, 1),
(2, 2, 65.00, 130.00, 2, 2),
(3, 1, 250.00, 250.00, 3, 5),
(4, 2, 80.00, 160.00, 4, 4),
(5, 1, 65.00, 65.00, 5, 2),
(6, 1, 200.00, 200.00, 6, 7),
(7, 1, 120.00, 120.00, 7, 3),
(8, 1, 150.00, 150.00, 8, 10),
(9, 1, 250.00, 250.00, 9, 5),
(10, 2, 45.00, 90.00, 10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `ID_empleado` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(80) NOT NULL,
  `DNI` varchar(8) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `Rol` varchar(50) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Clave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`ID_empleado`, `Nombre`, `Apellido`, `DNI`, `Telefono`, `Rol`, `Usuario`, `Clave`) VALUES
(1, 'Admin', 'Sistema', '00000001', '900000001', 'admin', 'admin', 'admin123'),
(2, 'Pedro', 'Vega', '12345678', '900000002', 'vendedor', 'pvega', 'pedro12'),
(3, 'Sandra', 'Flores', '23456789', '900000003', 'vendedor', 'sflores', 'sandra12'),
(4, 'Roberto', 'Leon', '34567890', '900000004', 'vendedor', 'rleon', 'roberto12'),
(5, 'Carmen', 'Diaz', '45678901', '900000005', 'vendedor', 'cdiaz', 'carmen12'),
(6, 'Fernando', 'Ruiz', '56789012', '900000006', 'admin', 'fruiz', 'fernando12'),
(7, 'Patricia', 'Mora', '67890123', '900000007', 'vendedor', 'pmora', 'patricia12'),
(8, 'Ricardo', 'Peña', '78901234', '900000008', 'vendedor', 'rpena', 'ricardo12'),
(9, 'Valeria', 'Cruz', '89012345', '900000009', 'vendedor', 'vcruz', 'valeria12'),
(10, 'Eduardo', 'Soto', '90123456', '900000010', 'vendedor', 'esoto', 'eduardo12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `ID_producto` int(11) NOT NULL,
  `Nombre_producto` varchar(100) NOT NULL,
  `Talla` varchar(10) NOT NULL,
  `Color` varchar(100) NOT NULL,
  `Marca` varchar(100) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Stock` int(11) NOT NULL DEFAULT 0,
  `CATEGORIA_ID_categoria` int(11) NOT NULL,
  `imagen` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`ID_producto`, `Nombre_producto`, `Talla`, `Color`, `Marca`, `Precio`, `Stock`, `CATEGORIA_ID_categoria`, `imagen`) VALUES
(1, 'Polo Clasico', 'M', 'Blanco', 'Adidas', 45.00, 50, 1, 'https://media.falabella.com/falabellaPE/20738940_1/w=1200,h=1200,fit=pad'),
(2, 'Polo Oversize', 'L', 'Negro', 'Nike', 65.00, 30, 1, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTKsnWq9v20OjXbZbJC1p9zDqYHGKnv4HPQYQ&s'),
(3, 'Jean Slim Fit', '32', 'Azul', 'Levis', 120.00, 20, 2, 'https://media.falabella.com/falabellaPE/18222018_1/w=1200,h=1200,fit=pad'),
(4, 'Jogger Deportivo', 'M', 'Gris', 'Puma', 80.00, 25, 2, 'https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,e_sharpen:95,w_2000,h_2000/global/627458/03/mod01/fnd/PER/fmt/png/Pantal%C3%B3n-jogger-BMW-M-Motorsport-para-hombre'),
(5, 'Zapatilla Running', '42', 'Blanco', 'Nike', 250.00, 15, 3, 'https://d3fvqmu2193zmz.cloudfront.net/items_2/uid_commerces.1/uid_items_2.FDLWRPJBSOC5/1500x1500/66BCDA937D098-Zapatilla-Running-Hombre-Interact-Run.webp'),
(6, 'Zapatilla Casual', '40', 'Negro', 'Adidas', 180.00, 18, 3, 'https://oechsle.vteximg.com.br/arquivos/ids/15231504-1000-1000/Zapatillas-para-Hombre-Adidas-GW9251-Grand-Court-Td-Lifestyle-Court-Casual-Negro.jpg?v=638278791770500000'),
(7, 'Casaca Impermeable', 'L', 'Negro', 'Adidas', 200.00, 10, 4, 'https://rimage.ripley.com.pe/home.ripley/Attachment/WOP/1/2020251259277/image2-2020251259277.jpg'),
(8, 'Short Deportivo', 'M', 'Azul', 'Under A.', 55.00, 40, 5, 'https://simple.ripley.com.pe/product/_next/image?url=https%3A%2F%2Frimage.ripley.com.pe%2Fhome.ripley%2FAttachment%2FWOP%2F1%2F2020264572325%2Ffull_image-2020264572325.&w=3840&q=100'),
(9, 'Camisa Oxford', 'L', 'Celeste', 'Tommy', 110.00, 22, 7, 'https://shopallseasonsco.com/cdn/shop/files/FullSizeRender_d8916d66-16df-42e7-a26a-75a60f621f4d.jpg?v=1739932553'),
(10, 'Buzo Completo', 'XL', 'Verde', 'Puma', 150.00, 12, 8, 'https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,e_sharpen:95,w_2000,h_2000/global/627428/86/mod03/fnd/PER/fmt/png/Casaca-PUMA-x-SQUID-GAME-T7-para-hombre'),
(11, 'Casaca Hombre', 'M,L,S,XL', 'Marron', 'DENIMLAB', 174.93, 100, 4, 'https://media.falabella.com/falabellaPE/883692456_1/w=1200,h=1200,fit=pad'),
(12, 'Polo de vestir Barcelona', 'S, L, M, X', 'Blaugrana', 'Barca', 60.00, 300, 1, 'https://cdn.kickitshirts.com/2025/03/Barcelona-Polo-Shirt-202526.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `ID_venta` int(11) NOT NULL,
  `Fecha_venta` datetime NOT NULL DEFAULT current_timestamp(),
  `IGV` decimal(10,2) NOT NULL DEFAULT 18.00,
  `Descuento` decimal(10,2) NOT NULL DEFAULT 0.00,
  `Total` decimal(10,2) NOT NULL,
  `Estado` varchar(50) NOT NULL DEFAULT 'pendiente',
  `Metodo_pago` varchar(50) NOT NULL,
  `Fecha_entrega` date NOT NULL,
  `EMPLEADO_ID_empleado` int(11) NOT NULL,
  `CLIENTE_ID_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`ID_venta`, `Fecha_venta`, `IGV`, `Descuento`, `Total`, `Estado`, `Metodo_pago`, `Fecha_entrega`, `EMPLEADO_ID_empleado`, `CLIENTE_ID_cliente`) VALUES
(1, '2026-05-01 09:00:00', 18.00, 0.00, 53.10, 'completado', 'efectivo', '2026-05-02', 2, 1),
(2, '2026-05-02 10:30:00', 18.00, 5.00, 141.30, 'completado', 'tarjeta', '2026-05-03', 3, 2),
(3, '2026-05-03 11:00:00', 18.00, 0.00, 295.00, 'completado', 'yape', '2026-05-04', 2, 3),
(4, '2026-05-05 14:00:00', 18.00, 10.00, 198.00, 'completado', 'efectivo', '2026-05-06', 4, 4),
(5, '2026-05-08 09:30:00', 18.00, 0.00, 76.70, 'completado', 'tarjeta', '2026-05-09', 3, 5),
(6, '2026-05-10 16:00:00', 18.00, 0.00, 236.00, 'pendiente', 'yape', '2026-05-12', 5, 6),
(7, '2026-05-12 10:00:00', 18.00, 5.00, 124.20, 'completado', 'efectivo', '2026-05-13', 2, 7),
(8, '2026-05-15 11:30:00', 18.00, 0.00, 177.00, 'completado', 'tarjeta', '2026-05-16', 6, 8),
(9, '2026-05-18 08:00:00', 18.00, 15.00, 318.50, 'pendiente', 'efectivo', '2026-05-20', 3, 9),
(10, '2026-05-20 17:00:00', 18.00, 0.00, 94.40, 'anulado', 'yape', '2026-05-22', 4, 10);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID_categoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID_cliente`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`ID_detalle`),
  ADD KEY `DETALLE_VENTA_VENTA_FK` (`VENTA_ID_venta`),
  ADD KEY `DETALLE_VENTA_PRODUCTO_FK` (`PRODUCTO_ID_producto`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`ID_empleado`),
  ADD UNIQUE KEY `DNI` (`DNI`),
  ADD UNIQUE KEY `Usuario` (`Usuario`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`ID_producto`),
  ADD KEY `PRODUCTO_CATEGORIA_FK` (`CATEGORIA_ID_categoria`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`ID_venta`),
  ADD KEY `VENTA_EMPLEADO_FK` (`EMPLEADO_ID_empleado`),
  ADD KEY `VENTA_CLIENTE_FK` (`CLIENTE_ID_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `ID_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `ID_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `ID_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `ID_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `DETALLE_VENTA_PRODUCTO_FK` FOREIGN KEY (`PRODUCTO_ID_producto`) REFERENCES `producto` (`ID_producto`),
  ADD CONSTRAINT `DETALLE_VENTA_VENTA_FK` FOREIGN KEY (`VENTA_ID_venta`) REFERENCES `venta` (`ID_venta`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `PRODUCTO_CATEGORIA_FK` FOREIGN KEY (`CATEGORIA_ID_categoria`) REFERENCES `categoria` (`ID_categoria`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `VENTA_CLIENTE_FK` FOREIGN KEY (`CLIENTE_ID_cliente`) REFERENCES `cliente` (`ID_cliente`),
  ADD CONSTRAINT `VENTA_EMPLEADO_FK` FOREIGN KEY (`EMPLEADO_ID_empleado`) REFERENCES `empleado` (`ID_empleado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
