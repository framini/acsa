-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 16-03-2012 a las 14:50:21
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
  `user_agent` varchar(120) collate utf8_bin default NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text collate utf8_bin,
  PRIMARY KEY  (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcar la base de datos para la tabla `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('286f7ee8d7f8a81b4c0f5e578934a766', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', 1331908910, 'a:6:{s:7:"user_id";s:1:"1";s:8:"username";s:4:"fran";s:10:"empresa_id";s:1:"1";s:6:"status";s:1:"1";s:8:"es_admin";s:1:"1";s:7:"empresa";s:101:"O:7:"Empresa":3:{s:6:"nombre";s:18:"Argentina Clearing";s:4:"cuit";s:9:"123456789";s:2:"id";s:1:"1";}";}');

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
  `grupos_fields_id` int(11) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Volcar la base de datos para la tabla `fields`
--

INSERT INTO `fields` (`fields_id`, `grupos_fields_id`, `fields_nombre`, `fields_label`, `fields_instrucciones`, `fields_value_defecto`, `fields_requerido`, `fields_hidden`, `fields_posicion`, `fields_type_id`, `fields_option_items`) VALUES
(21, 5, 'nombre', 'Nombre', 'sdasd', 'perro', 0, 0, 1, 1, ''),
(22, 5, 'direccion', 'Direccion', 'asdsad', '', 1, 0, 2, 1, ''),
(24, 7, 'cuerpo_noticia', 'Cuerpo de la noticia', 'Contenido de la noticia', '', 1, 0, 1, 2, ''),
(25, 7, 'enlaces', 'Enlances varios', 'Links relaciones a la noticia', '', 1, 0, 2, 1, ''),
(34, 7, 'autores', 'Autores', 'sdasdasdasd', NULL, 0, 0, 3, 1, NULL);

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
  `forms_nombre_action` varchar(250) default NULL,
  `grupos_fields_id` int(11) NOT NULL,
  `forms_descripcion` varchar(500) default NULL,
  `forms_titulo` varchar(250) default NULL,
  `forms_texto_boton_enviar` varchar(50) NOT NULL default 'Enviar',
  PRIMARY KEY  (`forms_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcar la base de datos para la tabla `forms`
--

INSERT INTO `forms` (`forms_id`, `forms_nombre`, `forms_nombre_action`, `grupos_fields_id`, `forms_descripcion`, `forms_titulo`, `forms_texto_boton_enviar`) VALUES
(1, 'productos', 'sd', 5, 'asdasdasd asdasdk oasd', 'Productos', 'ENVIAR!'),
(8, 'noticias', '', 7, 'Formulario para noticias', 'Noticias', 'Enviar Noticia!');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forms_data`
--

CREATE TABLE IF NOT EXISTS `forms_data` (
  `entry_id` int(11) NOT NULL,
  `forms_id` int(11) NOT NULL,
  `field_id_21` text,
  `field_id_22` text,
  `field_id_24` text,
  `field_id_25` text,
  `field_id_0` text,
  `field_id_34` text,
  PRIMARY KEY  (`entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `forms_data`
--

INSERT INTO `forms_data` (`entry_id`, `forms_id`, `field_id_21`, `field_id_22`, `field_id_24`, `field_id_25`, `field_id_0`, `field_id_34`) VALUES
(1, 8, NULL, NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac placerat odio. Integer ac enim in dui sollicitudin ultrices eget ac est. Nunc ac dui vitae libero congue tempor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce laoreet ultrices nisl a rhoncus. Morbi lacinia porta ligula, eu tempor lacus suscipit quis. Cras eget nisi in est vehicula malesuada sit amet ut velit. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 'mail.google.com', NULL, NULL),
(6, 1, 'perro', 'asd', NULL, NULL, NULL, NULL),
(7, 8, NULL, NULL, 'Aenean quis nunc id ipsum lacinia accumsan. Nunc egestas sem vitae leo consectetur dapibus eleifend odio ultrices. Suspendisse potenti. In ante ipsum, posuere eu eleifend vitae, laoreet ut ante. Etiam ut metus et mauris ornare dictum sed a ipsum. Morbi quis nisl in risus lobortis eleifend. Cras ullamcorper convallis accumsan. Aenean nunc leo, varius sed aliquam vel, luctus id turpis. Phasellus congue sapien non tellus pellentesque ac interdum ipsum pharetra. In elit felis, tristique sed pharetra ac, tempor eget velit. Ut ac diam eu justo vestibulum adipiscing non eu lorem. Nulla lectus elit, rhoncus vitae commodo eget, aliquam nec massa. Curabitur mollis, odio vitae pellentesque mattis, nisi orci viverra sapien, tempus gravida sem massa sit amet nunc. Nulla cursus, leo at lobortis venenatis, est neque egestas nisi, vel congue nisl diam a mi. Nulla quis erat sit amet tortor egestas semper ac ac nisi.\r\n\r\nSuspendisse ultrices metus aliquet neque rutrum sollicitudin. Aenean a nunc at sapien tempor adipiscing id ac risus. Vestibulum varius posuere convallis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam erat volutpat. Cras aliquam vestibulum vehicula. In bibendum eleifend lorem, et sollicitudin nibh posuere nec. Sed tristique cursus urna ut lacinia. Pellentesque eget tellus in libero fringilla ultricies non ac nunc. Quisque lorem libero, malesuada vitae laoreet a, rutrum et sapien. Praesent dignissim lectus vel tortor accumsan consequat. Mauris malesuada velit lorem. Quisque eget dictum metus. Sed dignissim dolor sem. ', 'http://yahoo.com', NULL, 'Kito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forms_entradas`
--

CREATE TABLE IF NOT EXISTS `forms_entradas` (
  `entry_id` int(11) NOT NULL auto_increment,
  `forms_id` int(11) NOT NULL,
  `autor_id` int(11) NOT NULL,
  `ip_address` varchar(16) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `url_titulo` varchar(100) NOT NULL,
  `contador_visitas_1` int(11) NOT NULL default '0',
  `contador_visitas_2` int(11) NOT NULL default '0',
  `entry_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `edit_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`entry_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcar la base de datos para la tabla `forms_entradas`
--

INSERT INTO `forms_entradas` (`entry_id`, `forms_id`, `autor_id`, `ip_address`, `titulo`, `url_titulo`, `contador_visitas_1`, `contador_visitas_2`, `entry_date`, `edit_date`) VALUES
(1, 8, 1, '127.0.0.1', 'Titulo de la noticia 2', 'titulo_de_la_noticia', 0, 0, '2012-03-07 17:59:21', '2012-03-07 20:10:57'),
(6, 1, 1, '127.0.0.1', 'sadsadsa', 'sadsadsa', 0, 0, '2012-03-08 15:03:23', '2012-03-08 15:03:23'),
(7, 8, 1, '127.0.0.1', 'titNuevo', 'titnuevo', 0, 0, '2012-03-15 18:50:50', '2012-03-16 14:32:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_fields`
--

CREATE TABLE IF NOT EXISTS `grupos_fields` (
  `grupos_fields_id` int(11) NOT NULL auto_increment,
  `grupos_fields_nombre` varchar(50) NOT NULL,
  PRIMARY KEY  (`grupos_fields_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcar la base de datos para la tabla `grupos_fields`
--

INSERT INTO `grupos_fields` (`grupos_fields_id`, `grupos_fields_nombre`) VALUES
(5, 'secciones'),
(7, 'noticias');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

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
(25, 'modificar_grupo_fields', 'admin', 'grupos_fields', 1),
(26, 'modificar_form', 'admin', 'forms', 1);

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
-- Estructura de tabla para la tabla `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `template_id` int(11) NOT NULL auto_increment,
  `template_group_id` int(11) NOT NULL,
  `nombre` varchar(50) character set utf8 NOT NULL,
  `data` longtext character set utf8,
  `edit_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `autor_id` int(11) NOT NULL,
  `visitas` int(11) NOT NULL,
  PRIMARY KEY  (`template_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `templates`
--

INSERT INTO `templates` (`template_id`, `template_group_id`, `nombre`, `data`, `edit_date`, `autor_id`, `visitas`) VALUES
(1, 1, 'prueba', '<html>\r\n<head>\r\n<title>\r\nPPPRUEBA\r\n</title>\r\n</head>\r\n<body><div style="color:red">\r\n<p>sa</p>\r\n{% set entry_id %}\r\nSasdasdsaddsa\r\n{% endset %}\r\n{{ foo }}\r\n{{ entry_id }}\r\n{$form forms_nombre="noticias" entry_id="7" $}\r\n{% for entrada in contenido_form if loop.index < 4 %}\r\n        <li>{{ entrada.titulo }} - {{ entrada.enlaces }} - {{ entrada.autores }}</li>\r\n    {% endfor %}\r\n</div>\r\n</body>\r\n</html>', '2012-03-09 13:56:42', 1, 1),
(3, 1, 'tutu', '<html>\r\n<head>\r\n<title>\r\nHOLA\r\n</title>\r\n</head>\r\n<body>\r\n<h1>{{title}}</h1>\r\n{% for item in navigation %}\r\n            <li><a href="{{ item.href }}">{{ item.caption }}</a></li>\r\n        {% endfor %}\r\n\r\n{% filter upper %}\r\n  This text becomes uppercase\r\n{% endfilter %}\r\n\r\n{% include "welcome_message.php" %}\r\n</body>\r\n</html>', '2012-03-09 13:56:42', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `templates_groups`
--

CREATE TABLE IF NOT EXISTS `templates_groups` (
  `template_group_id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL,
  `grupo_default` char(1) character set utf8 NOT NULL default 'n',
  PRIMARY KEY  (`template_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `templates_groups`
--

INSERT INTO `templates_groups` (`template_group_id`, `nombre`, `grupo_default`) VALUES
(1, 'test', 'n');

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
(1, 1, 'fran', '$P$BOd3bMRhe5jVnl7auEicOuJ.zyLunF.', 'framini@gmail.com', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, '127.0.0.1', '2012-03-16 13:56:12', '2012-02-08 14:12:21', '2012-03-16 10:56:12', 1),
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
