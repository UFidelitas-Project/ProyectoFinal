-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 10-08-2020 a las 21:48:43
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `factura`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_temp` (IN `id` INT, IN `cantidad` INT, IN `token_user` VARCHAR(50))  BEGIN 
    DECLARE precio_actual decimal(10,2); 
    SELECT precio INTO precio_actual FROM producto WHERE idproducto = id; 
    INSERT INTO detalle_temp(token_user, idproducto, cantidad, precio_venta) VALUES(token_user, id, cantidad, precio_actual); 
    SELECT tmp.id_detemp, tmp.idproducto, p.descripcion, tmp.cantidad, tmp.precio_venta FROM 			detalle_temp tmp INNER JOIN producto p ON tmp.idproducto = p.idproducto WHERE 					tmp.token_user = token_user; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp` (IN `id_detalle` INT, IN `token` VARCHAR(50))  BEGIN    	
        DELETE FROM detalle_temp WHERE id_detemp = id_detalle;
        
        SELECT tmp.id_detemp, tmp.idproducto, p.descripcion, tmp.cantidad, tmp.precio_venta
        FROM detalle_temp tmp INNER JOIN producto p ON tmp.idproducto = p.idproducto
        WHERE tmp.token_user = token;       
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_venta` (`id_usuario` INT, `id_cliente` INT, `token` VARCHAR(50))  BEGIN 
    	DECLARE factura int;
        DECLARE registros int;
        DECLARE total decimal(10,2);
        DECLARE nueva_existencia int;
        DECLARE existencia_actual int;
        DECLARE tmp_id_producto int;
        DECLARE tmp_cant_producto int;
        DECLARE a int;
        SET a = 1;
        
        CREATE TEMPORARY TABLE tbl_tmp_tokenuser(
        	id bigint NOT null AUTO_INCREMENT PRIMARY KEY,
            id_prod bigint,
            cant_prod int);
        
        SET registros = (SELECT COUNT(*) FROM detalle_temp WHERE token_user = token);
        
        IF registros > 0 THEN 
        	INSERT INTO tbl_tmp_tokenuser(id_prod,cant_prod) SELECT idproducto,cantidad FROM detalle_temp WHERE token_user = token;
            
            INSERT INTO factura(usuario,idcliente) VALUES (id_usuario,id_cliente);
            SET factura = LAST_INSERT_ID();
            
            INSERT INTO detallefactura(nofactura,idproducto,cantidad,precio_venta) SELECT (factura) as nofactura,idproducto,cantidad,precio_venta 				FROM detalle_temp WHERE token_user = token;
            
            WHILE a <= registros DO
            	SELECT id_prod,cant_prod INTO tmp_id_producto,tmp_cant_producto FROM tbl_tmp_tokenuser WHERE id = a;
                SELECT existencia INTO existencia_actual FROM producto WHERE idproducto = tmp_id_producto;
                
                SET nueva_existencia = existencia_actual - tmp_cant_producto;
                UPDATE producto SET existencia = nueva_existencia WHERE idproducto = tmp_id_producto;
            	
                SET a = a + 1;               
            END WHILE;
            
            SET total = (SELECT SUM(cantidad * precio_venta) FROM detalle_temp WHERE token_user = token);
            UPDATE factura SET totalfactura = total WHERE nofactura = factura;
            DELETE FROM detalle_temp WHERE token_user = token;
            TRUNCATE TABLE tbl_tmp_tokenuser;
            SELECT * FROM factura WHERE nofactura = factura;
            
        ELSE
        	SELECT 0;
        END IF;
            
        
 	END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `telefono` int(11) NOT NULL,
  `direccion` text NOT NULL,
  `dateadd` datetime NOT NULL DEFAULT current_timestamp(),
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `cedula`, `nombre`, `telefono`, `direccion`, `dateadd`, `estatus`) VALUES
(1, 987654321, 'Katherine', 23543212, 'Desamparados de alajuela', '2020-07-11 09:48:47', 1),
(2, 234565432, 'Monica', 34543234, 'Alajuela', '2020-07-11 10:09:23', 0),
(3, 123456789, 'Ana Maria ', 23452345, 'San Jose Costa Rica', '2020-07-18 20:56:44', 1),
(4, 334563456, 'Isis Salas', 65876543, 'Desamparados de alajuela', '2020-07-21 18:30:10', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_empresa`
--

CREATE TABLE `datos_empresa` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `direccion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `datos_empresa`
--

INSERT INTO `datos_empresa` (`id`, `nombre`, `telefono`, `email`, `direccion`) VALUES
(1, 'Ferreteria Los Angeles', 23452345, 'losangeles@ferreteria.com', 'Alajuela, Costa Rica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

CREATE TABLE `detallefactura` (
  `id_defactura` bigint(11) NOT NULL,
  `nofactura` bigint(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detallefactura`
--

INSERT INTO `detallefactura` (`id_defactura`, `nofactura`, `idproducto`, `cantidad`, `precio_venta`) VALUES
(1, 1, 1, 1, '1200.00'),
(2, 1, 1, 1, '1200.00'),
(4, 2, 1, 1, '1200.00'),
(5, 3, 1, 1, '1200.00'),
(6, 3, 1, 1, '1200.00'),
(8, 4, 1, 4, '1200.00'),
(9, 5, 1, 1, '1200.00'),
(10, 6, 1, 1, '1200.00'),
(11, 7, 1, 1, '1200.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp`
--

CREATE TABLE `detalle_temp` (
  `id_detemp` int(11) NOT NULL,
  `token_user` varchar(50) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `nofactura` bigint(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `idcliente` int(11) NOT NULL,
  `totalfactura` decimal(10,2) DEFAULT NULL,
  `usuario` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`nofactura`, `fecha`, `idcliente`, `totalfactura`, `usuario`, `estatus`) VALUES
(1, '2020-07-20 14:26:50', 3, '2400.00', 1, 1),
(2, '2020-07-20 14:30:03', 1, '1200.00', 1, 1),
(3, '2020-07-20 15:16:51', 3, '2400.00', 1, 1),
(4, '2020-07-20 15:28:37', 1, '4800.00', 1, 1),
(5, '2020-07-20 15:56:37', 3, '1200.00', 1, 1),
(6, '2020-07-21 18:25:38', 3, '1200.00', 1, 1),
(7, '2020-08-02 16:14:11', 3, '1200.00', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `proveedor` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `existencia` int(11) DEFAULT NULL,
  `dateadd` datetime NOT NULL DEFAULT current_timestamp(),
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `descripcion`, `proveedor`, `precio`, `existencia`, `dateadd`, `estatus`) VALUES
(1, 'BALDWIN CERRADURA MANIJA NEGRA 353MDL ARB 11P (93530-004)', 12, '1200.00', 11, '2020-07-12 09:08:56', 1),
(2, 'Helado de fresa', 12, '500.00', 45, '2020-07-31 15:14:40', 1),
(3, 'Helado de naranja', 12, '500.00', 45, '2020-07-31 15:15:15', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idproveedor` int(11) NOT NULL,
  `proveedor` varchar(100) NOT NULL,
  `telefono` int(11) NOT NULL,
  `direccion` text DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`idproveedor`, `proveedor`, `telefono`, `direccion`, `estatus`) VALUES
(12, 'Dos Pinos', 344654432, 'El coyol', 1),
(13, 'Florida', 346811234, 'San Jose', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `contraseña` varchar(100) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `correo`, `usuario`, `contraseña`, `estatus`) VALUES
(1, 'Katherine Rodriguez', 'admin@admin.com', 'admin', '123', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `datos_empresa`
--
ALTER TABLE `datos_empresa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`id_defactura`),
  ADD KEY `codproducto` (`idproducto`),
  ADD KEY `nofactura` (`nofactura`);

--
-- Indices de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD PRIMARY KEY (`id_detemp`),
  ADD KEY `nofactura` (`token_user`),
  ADD KEY `codproducto` (`idproducto`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`nofactura`),
  ADD KEY `codcliente` (`idcliente`),
  ADD KEY `fk_usuario` (`usuario`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `proveedor` (`proveedor`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idproveedor`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `datos_empresa`
--
ALTER TABLE `datos_empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  MODIFY `id_defactura` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  MODIFY `id_detemp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `nofactura` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD CONSTRAINT `detallefactura_ibfk_1` FOREIGN KEY (`nofactura`) REFERENCES `factura` (`nofactura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detallefactura_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD CONSTRAINT `detalle_temp_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`proveedor`) REFERENCES `proveedor` (`idproveedor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
