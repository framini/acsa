-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 02-03-2012 a las 20:59:06
-- Versión del servidor: 5.0.45
-- Versión de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `acsa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) collate utf8_bin NOT NULL default '0',
  `ip_address` varchar(16) collate utf8_bin NOT NULL default '0',
  `user_agent` varchar(150) collate utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text collate utf8_bin,
  PRIMARY KEY  (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcar la base de datos para la tabla `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('dd860e1a99368349a13c32d3ca6bea77', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1; rv:10.0.2) Gecko/2010', 1330721010, 'a:6:{s:7:"user_id";s:1:"1";s:8:"username";s:4:"fran";s:10:"empresa_id";s:1:"1";s:6:"status";s:1:"1";s:8:"es_admin";s:1:"1";s:7:"empresa";s:101:"O:7:"Empresa":3:{s:6:"nombre";s:18:"Argentina Clearing";s:4:"cuit";s:9:"123456789";s:2:"id";s:1:"1";}";}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_registro`
--

CREATE TABLE IF NOT EXISTS `cuentas_registro` (
  `cuentaregistro_id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL,
  `codigo` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `tipo_cuentaregistro_id` int(11) NOT NULL,
  `persona_id` int(11) default NULL,
  PRIMARY KEY  (`cuentaregistro_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcar la base de datos para la tabla `cuentas_registro`
--

INSERT INTO `cuentas_registro` (`cuentaregistro_id`, `nombre`, `codigo`, `empresa_id`, `tipo_cuentaregistro_id`, `persona_id`) VALUES
(1, 'Banco 1', 1, 2, 1, NULL),
(2, 'Banco 2', 2, 2, 2, NULL),
(3, 'Financiera 1', 3, 2, 1, NULL),
(4, 'Financiera 2', 4, 2, 2, NULL),
(5, 'Financiador 1', 5, 3, 1, 0),
(6, 'Depositante 1', 6, 3, 0, 0),
(7, 'Financiador 3', 7, 3, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE IF NOT EXISTS `empresas` (
  `empresa_id` int(30) NOT NULL auto_increment,
  `empresa_asoc_id` int(11) default '0',
  `tipo_empresa_id` int(30) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `cuit` varchar(50) NOT NULL,
  `fecha_alta` date NOT NULL,
  `activated` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`empresa_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`empresa_id`, `empresa_asoc_id`, `tipo_empresa_id`, `nombre`, `cuit`, `fecha_alta`, `activated`) VALUES
(1, 0, 1, 'Argentina Clearing', '123456789', '2011-06-09', 1),
(2, 0, 2, 'Warrantera 1', '123456', '2011-06-18', 1),
(3, 0, 2, 'Warrantera 2', '1234', '2011-09-13', 1),
(4, 0, 3, 'petrolera_tes', '11002233', '2012-02-17', 1),
(5, 0, 3, 'petrolera', '78976122', '2012-02-17', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ewarrant`
--

CREATE TABLE IF NOT EXISTS `ewarrant` (
  `id` int(11) NOT NULL auto_increment,
  `codigo` varchar(50) NOT NULL,
  `cuentaregistro_depositante_id` int(11) NOT NULL,
  `cuentaregistro_id` int(11) NOT NULL,
  `producto` varchar(50) NOT NULL,
  `kilos` int(11) NOT NULL,
  `observaciones` varchar(100) NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `estado` tinyint(1) NOT NULL,
  `emitido_por` int(11) NOT NULL,
  `firmado` tinyint(1) NOT NULL default '0',
  `empresa_id` int(11) NOT NULL,
  `empresa_nombre` varchar(50) NOT NULL,
  `empresa_cuit` int(11) NOT NULL,
  `precio_ponderado` float NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Volcar la base de datos para la tabla `ewarrant`
--

INSERT INTO `ewarrant` (`id`, `codigo`, `cuentaregistro_depositante_id`, `cuentaregistro_id`, `producto`, `kilos`, `observaciones`, `created`, `estado`, `emitido_por`, `firmado`, `empresa_id`, `empresa_nombre`, `empresa_cuit`, `precio_ponderado`) VALUES
(16, '789999666333', 5, 5, 'Soja', 456, 'ffdsd fsdfsdf sf sfsd fsdf sdfsdfsd', '2012-02-17 18:07:58', 1, 2, 0, 3, 'Warrantera 2', 1234, 581400),
(15, '789', 5, 5, 'Trigo', 789, 'trigo nota', '2012-02-17 18:05:09', 1, 2, 0, 3, 'Warrantera 2', 1234, 224865),
(14, '123456', 5, 5, 'Trigo', 123, 'asda asdas da', '2012-02-17 18:01:56', 1, 2, 0, 3, 'Warrantera 2', 1234, 35055),
(10, '000002', 5, 5, '', 2000, 'None', '2011-10-31 20:48:53', 1, 2, 0, 3, 'Warrantera 2', 1234, 570000),
(11, '000005', 5, 5, 'Soja', 21, 'sadasd', '2011-11-01 12:57:41', 1, 2, 0, 3, 'Warrantera 2', 1234, 26775),
(12, '0000010', 5, 5, 'Soja', 2000, 'Ninguna', '2011-11-15 21:04:41', 1, 2, 0, 3, 'Warrantera 2', 1234, 2.55e+006),
(13, '00000523', 5, 5, 'Soja', 78963, 'None', '2012-02-14 17:46:35', 0, 2, 1, 3, 'Warrantera 2', 1234, 1.00678e+008),
(17, '456', 7, 7, 'Trigo', 78, 'tyu tyutyu ty utyuty utyu tyu tyutuytutyutyutyu', '2012-02-17 18:09:19', 1, 2, 0, 3, 'Warrantera 2', 1234, 22230);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fields`
--

CREATE TABLE IF NOT EXISTS `fields` (
  `fields_id` int(11) NOT NULL auto_increment,
  `fields_nombre` varchar(50) NOT NULL,
  `fields_label` varchar(50) NOT NULL,
  `fields_instrucciones` varchar(50) NOT NULL,
  `fields_value_defecto` varchar(250) default '',
  `fields_requerido` tinyint(4) default '0',
  `fields_hidden` tinyint(4) default '0',
  `fields_posicion` int(11) default NULL,
  `fields_type_id` int(11) NOT NULL,
  `fields_option_items` varchar(500) default NULL,
  PRIMARY KEY  (`fields_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcar la base de datos para la tabla `fields`
--

INSERT INTO `fields` (`fields_id`, `fields_nombre`, `fields_label`, `fields_instrucciones`, `fields_value_defecto`, `fields_requerido`, `fields_hidden`, `fields_posicion`, `fields_type_id`, `fields_option_items`) VALUES
(2, 'nombre_producto', 'Nombre del Producto', 'none', 'asd', 0, 0, 2, 1, ''),
(3, 'nombre_producto_2', 'Nombre del Producto', 'none', NULL, 0, 0, 1, 1, ''),
(4, 'cantidad_producto', 'Cantidad Producto', 'none', NULL, 0, 0, 4, 1, ''),
(5, 'descripcion_producto', 'Descripcion Producto', 'Breve descripcion del producto', NULL, 0, 0, 5, 1, ''),
(7, 'lista', 'Lista', 'Lista dropdown', NULL, 1, 0, 6, 5, '"val1":"Opcion 1",\r\n"val2": "Opcion 2",\r\n"salgo": "Salgo 2",\r\n"valNuevo": "Perro"'),
(8, 'lista_2', 'Lista 2', 'ninguna', NULL, 0, 0, 8, 6, '"eq1":"uno",\r\n"eq2":"dos"'),
(11, 'check3', 'Checkbox 3', 'sd', NULL, 0, 0, 10, 4, '"opt1": "val1",\r\n"opt2": "val2"'),
(12, 'radio_name', 'Prueba Radios', 'none', NULL, 0, 0, 12, 3, '"Label 1":"valor1",\r\n"Label 2":"valor2"');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fields_types`
--

CREATE TABLE IF NOT EXISTS `fields_types` (
  `fields_type_id` int(11) NOT NULL auto_increment,
  `fields_type_nombre` varchar(50) NOT NULL,
  PRIMARY KEY  (`fields_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcar la base de datos para la tabla `fields_types`
--

INSERT INTO `fields_types` (`fields_type_id`, `fields_type_nombre`) VALUES
(1, 'text'),
(2, 'textarea'),
(3, 'radio'),
(4, 'checkbox'),
(5, 'dropdown'),
(6, 'multiselect');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forms`
--

CREATE TABLE IF NOT EXISTS `forms` (
  `forms_id` int(11) NOT NULL auto_increment,
  `forms_nombre` varchar(50) NOT NULL,
  `forms_nombre_action` varchar(250) NOT NULL,
  `grupos_fields_id` int(11) NOT NULL,
  `forms_descripcion` varchar(500) default NULL,
  `forms_titulo` varchar(250) default NULL,
  `forms_texto_boton_enviar` varchar(50) NOT NULL default 'Enviar',
  PRIMARY KEY  (`forms_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `forms`
--

INSERT INTO `forms` (`forms_id`, `forms_nombre`, `forms_nombre_action`, `grupos_fields_id`, `forms_descripcion`, `forms_titulo`, `forms_texto_boton_enviar`) VALUES
(1, 'productos', 'pepe', 1, NULL, NULL, 'Enviar'),
(2, 'pepe', 'asd', 1, NULL, NULL, 'Enviar'),
(3, 'noticias_nuevas', 'publicar', 2, 'Form donde se publican noticias.', 'Noticias Varias', 'Enviar Noticia!');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_fields`
--

CREATE TABLE IF NOT EXISTS `grupos_fields` (
  `grupos_fields_id` int(11) NOT NULL auto_increment,
  `grupos_fields_nombre` varchar(50) NOT NULL,
  PRIMARY KEY  (`grupos_fields_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `grupos_fields`
--

INSERT INTO `grupos_fields` (`grupos_fields_id`, `grupos_fields_nombre`) VALUES
(1, 'Productos'),
(2, 'Quinotos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_fields_fields`
--

CREATE TABLE IF NOT EXISTS `grupos_fields_fields` (
  `grupo_fields_fields_id` int(11) NOT NULL auto_increment,
  `grupos_fields_id` int(11) NOT NULL,
  `fields_id` int(11) NOT NULL,
  PRIMARY KEY  (`grupo_fields_fields_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Volcar la base de datos para la tabla `grupos_fields_fields`
--

INSERT INTO `grupos_fields_fields` (`grupo_fields_fields_id`, `grupos_fields_id`, `fields_id`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 1, 4),
(4, 1, 5),
(5, 1, 6),
(6, 1, 7),
(7, 1, 8),
(8, 1, 9),
(9, 1, 10),
(10, 1, 11),
(11, 1, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL auto_increment,
  `ip_address` varchar(40) collate utf8_bin NOT NULL,
  `login` varchar(50) collate utf8_bin NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `login_attempts`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
  `permiso_id` int(11) NOT NULL auto_increment,
  `permiso` varchar(100) NOT NULL,
  `controladora` varchar(50) NOT NULL,
  `grupo` varchar(50) default NULL,
  `admin_only` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`permiso_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Volcar la base de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`permiso_id`, `permiso`, `controladora`, `grupo`, `admin_only`) VALUES
(5, 'emitir', 'ewarrants', NULL, 0),
(6, 'listar', 'ewarrants', NULL, 0),
(7, 'firma', 'ewarrants', NULL, 0),
(8, 'anular', 'ewarrants', NULL, 0),
(9, 'editar_usuario', 'seguridad', 'gestionar_usuarios', 0),
(10, 'cambiar_email', 'seguridad', 'gestionar_usuarios', 0),
(11, 'cambiar_password', 'seguridad', 'gestionar_usuarios', 0),
(12, 'eliminar_user', 'seguridad', 'gestionar_usuarios', 0),
(13, 'registro', 'seguridad', 'gestionar_usuarios', 0),
(14, 'nuevo_role', 'seguridad', 'gestionar_roles', 0),
(15, 'modificar_role', 'seguridad', 'gestionar_roles', 0),
(16, 'eliminar_role', 'seguridad', 'gestionar_roles', 0),
(17, 'registro_empresa', 'seguridad', 'gestionar_empresas', 1),
(18, 'modificar_empresa', 'seguridad', 'gestionar_empresas', 1),
(19, 'eliminar_empresa', 'seguridad', 'gestionar_empresas', 1),
(20, 'activar_empresa', 'seguridad', 'gestionar_empresas', 1),
(21, 'alta_formulario', 'admin', 'forms', 1),
(22, 'alta_grupos_fields', 'admin', 'grupos_fields', 1),
(23, 'alta_fields', 'admin', 'fields', 1),
(24, 'modificar_field', 'admin', 'fields', 1),
(25, 'fields', 'admin', 'grupos_fields', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `producto_id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL,
  `precio` float NOT NULL,
  `calidad` varchar(50) NOT NULL,
  `aforo` int(11) NOT NULL,
  PRIMARY KEY  (`producto_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `productos`
--

INSERT INTO `productos` (`producto_id`, `nombre`, `precio`, `calidad`, `aforo`) VALUES
(1, 'Soja', 50, 'Fabrica', 2),
(4, 'Trigo', 10, 'Camara', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(30) NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `empresa_id` varchar(50) NOT NULL,
  `tipo_empresa_id` int(30) NOT NULL,
  PRIMARY KEY  (`role_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

--
-- Volcar la base de datos para la tabla `roles`
--

INSERT INTO `roles` (`role_id`, `nombre`, `descripcion`, `empresa_id`, `tipo_empresa_id`) VALUES
(1, 'Admin', 'UN ADMIN MODSADASD', '1', 1),
(3, 'guest', 'es un guest', '1', 1),
(54, 'asdasd1322', 'adasd asdsad asdsaasd', '2', 2),
(52, 'moderadord', 'asd', '2', 2),
(51, 'moderador', 'Un Moderador', '2', 2),
(56, 'emp_quique_1', 'Role 1', '3', 2),
(57, 'emp_quique_2', 'Role 2', '3', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permisos`
--

CREATE TABLE IF NOT EXISTS `roles_permisos` (
  `role_permiso_id` int(11) NOT NULL auto_increment,
  `role_id` int(30) NOT NULL,
  `permiso_id` int(30) NOT NULL,
  PRIMARY KEY  (`role_permiso_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=469 ;

--
-- Volcar la base de datos para la tabla `roles_permisos`
--

INSERT INTO `roles_permisos` (`role_permiso_id`, `role_id`, `permiso_id`) VALUES
(151, 1, 6),
(59, 3, 3),
(155, 56, 4),
(60, 3, 4),
(150, 1, 5),
(149, 1, 4),
(154, 56, 1),
(58, 3, 2),
(57, 3, 1),
(148, 1, 2),
(147, 1, 1),
(468, 57, 16),
(152, 1, 7),
(153, 1, 8),
(156, 56, 12),
(157, 56, 13),
(467, 57, 15),
(466, 57, 14),
(465, 57, 13),
(464, 57, 12),
(463, 57, 11),
(462, 57, 10),
(461, 57, 9),
(460, 57, 7),
(459, 57, 6),
(458, 57, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cuenta_registro`
--

CREATE TABLE IF NOT EXISTS `tipo_cuenta_registro` (
  `tipo_cuentaregistro_id` int(11) NOT NULL auto_increment,
  `descripcion` varchar(100) NOT NULL,
  `es_depositante` tinyint(1) NOT NULL,
  PRIMARY KEY  (`tipo_cuentaregistro_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `tipo_cuenta_registro`
--

INSERT INTO `tipo_cuenta_registro` (`tipo_cuentaregistro_id`, `descripcion`, `es_depositante`) VALUES
(1, 'Depositante', 1),
(2, 'No depositante', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_empresa`
--

CREATE TABLE IF NOT EXISTS `tipo_empresa` (
  `tipo_empresa_id` int(30) NOT NULL auto_increment,
  `tipo_empresa` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY  (`tipo_empresa_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `tipo_empresa`
--

INSERT INTO `tipo_empresa` (`tipo_empresa_id`, `tipo_empresa`, `descripcion`) VALUES
(2, 'warrantera', 'Una Warrantera'),
(3, 'depositante', 'Empresa Depositante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL auto_increment,
  `empresa_id` int(30) NOT NULL,
  `username` varchar(50) collate utf8_bin NOT NULL,
  `password` varchar(255) collate utf8_bin NOT NULL,
  `email` varchar(100) collate utf8_bin NOT NULL,
  `role_id` int(30) NOT NULL,
  `activated` tinyint(1) NOT NULL default '1',
  `banned` tinyint(1) NOT NULL default '0',
  `ban_reason` varchar(255) collate utf8_bin default NULL,
  `new_password_key` varchar(50) collate utf8_bin default NULL,
  `new_password_requested` datetime default NULL,
  `new_email` varchar(100) collate utf8_bin default NULL,
  `new_email_key` varchar(50) collate utf8_bin default NULL,
  `last_ip` varchar(40) collate utf8_bin NOT NULL,
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `es_admin` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=20 ;

--
-- Volcar la base de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `empresa_id`, `username`, `password`, `email`, `role_id`, `activated`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created`, `modified`, `es_admin`) VALUES
(1, 1, 'fran', '$P$BOd3bMRhe5jVnl7auEicOuJ.zyLunF.', 'framini@gmail.com', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', '2012-03-02 15:11:40', '2012-02-08 14:12:21', '2012-03-02 12:11:40', 1),
(2, 3, 'quique22', '$P$BZ0fG.P43iVTO.igIShUJrhplXawUc0', 'quiero_newage22@yahoo.com', 57, 1, 0, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', '2012-02-24 19:11:15', '2012-02-16 14:53:20', '2012-02-24 16:11:15', 0),
(11, 2, 'pepito', '$P$Ba77MDq6rBN0ec4zeGpJY6bKdF7TSy1', 'asdasd@d.com', 1, 1, 0, NULL, NULL, NULL, 'asdasdd@d.com', '28d617a7f3b1e3cedbe21c2fa567e1b8', '127.0.0.1', '0000-00-00 00:00:00', '2012-02-08 19:11:34', '2012-02-24 15:58:52', 0),
(19, 5, 'perrop', '$P$BWygQVlcCFBTKid0cERCt/tN1eBtOo1', 'asdasd@asd.com', 57, 0, 0, NULL, NULL, NULL, 'perro@perro.com', 'f62dcda436026f99d9b2f0f85de0483d', '127.0.0.1', '2012-02-23 20:43:18', '2012-02-16 15:01:40', '2012-02-24 16:06:04', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_autologin`
--

CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) collate utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `user_agent` varchar(150) collate utf8_bin NOT NULL,
  `last_ip` varchar(40) collate utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcar la base de datos para la tabla `user_autologin`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) collate utf8_bin default NULL,
  `website` varchar(255) collate utf8_bin default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=33 ;

--
-- Volcar la base de datos para la tabla `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `country`, `website`) VALUES
(9, 9, NULL, NULL),
(11, 11, NULL, NULL),
(16, 16, NULL, NULL),
(22, 9, NULL, NULL),
(24, 11, NULL, NULL),
(29, 16, NULL, NULL),
(32, 19, NULL, NULL);
