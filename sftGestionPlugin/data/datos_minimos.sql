INSERT INTO `eda_accesos` VALUES(1, 1, 1, 0, NULL, 1);

--
-- Volcar la base de datos para la tabla `eda_ambitos`
--


--
-- Volcar la base de datos para la tabla `eda_ambitos_i18n`
--


--
-- Volcar la base de datos para la tabla `eda_aplicaciones`
--

INSERT INTO `eda_aplicaciones` VALUES(1, 'GestionEDAE3', 'http://', 'https://gea.pntic.mec.es/RepositoriosSVN/GestionEDAE3', 'cambiar', 1, '2010-06-25 18:46:10', '2010-06-25 18:46:13');

--
-- Volcar la base de datos para la tabla `eda_credenciales`
--

INSERT INTO `eda_credenciales` VALUES(1, 1, 'AP_GestionEDAE3', 'Credencial de acceso de la aplicación GestionEDAE3');

--
-- Volcar la base de datos para la tabla `eda_culturas`
--

INSERT INTO `eda_culturas` VALUES(1, 'es_ES', 'Español');
INSERT INTO `eda_culturas` VALUES(2, 'en_GB', 'inglés');

--
-- Volcar la base de datos para la tabla `eda_direcciones`
--


--
-- Volcar la base de datos para la tabla `eda_emails`
--


--
-- Volcar la base de datos para la tabla `eda_identificaciones`
--


--
-- Volcar la base de datos para la tabla `eda_organismos`
--


--
-- Volcar la base de datos para la tabla `eda_perfiles`
--

INSERT INTO `eda_perfiles` VALUES(1, 1, NULL, '2010-06-25 18:34:55', '2010-06-25 18:34:58', NULL, 'SuperAdministrador.yml');

--
-- Volcar la base de datos para la tabla `eda_perfiles_i18n`
--

INSERT INTO `eda_perfiles_i18n` VALUES(1, 'Super Administrator', 'Whole System Administrator', 'SuperAdmin', 'en_GB');
INSERT INTO `eda_perfiles_i18n` VALUES(1, 'Super Administrador', 'Administrador del sistema completo', 'SuperAdmin', 'es_ES');

--
-- Volcar la base de datos para la tabla `eda_perfil_credencial`
--


--
-- Volcar la base de datos para la tabla `eda_periodos`
--

INSERT INTO `eda_periodos` VALUES(1, 1, '2010-06-25', NULL, 'Periodo UO Admin', 'ACTIVO');

--
-- Volcar la base de datos para la tabla `eda_personas`
--

INSERT INTO `eda_personas` VALUES(1, 'Zeus', 'Apolo', 'Dionisos', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Volcar la base de datos para la tabla `eda_telefonos`
--


--
-- Volcar la base de datos para la tabla `eda_tiposdireccion`
--


--
-- Volcar la base de datos para la tabla `eda_tiposdireccion_i18n`
--


--
-- Volcar la base de datos para la tabla `eda_tiposdocidentificacion`
--


--
-- Volcar la base de datos para la tabla `eda_tiposdocidentificacion_i18n`
--


--
-- Volcar la base de datos para la tabla `eda_tiposorganismo`
--


--
-- Volcar la base de datos para la tabla `eda_tiposorganismo_i18n`
--


--
-- Volcar la base de datos para la tabla `eda_tipostelefono`
--


--
-- Volcar la base de datos para la tabla `eda_tipostelefono_i18n`
--


--
-- Volcar la base de datos para la tabla `eda_uos`
--

INSERT INTO `eda_uos` VALUES(1, 'UOAdmin', 'UO para la administración del sistema', 'gral', NULL, NULL, '2010-06-25 18:31:38', '2010-06-25 18:31:42');

--
-- Volcar la base de datos para la tabla `eda_uos_i18n`
--

INSERT INTO `eda_uos_i18n` VALUES(1, 'Administration Organizative Unit', 'Admin OU', NULL, NULL, 'en_GB');
INSERT INTO `eda_uos_i18n` VALUES(1, 'Unidad Organizativa de Administración', 'UO Admin', NULL, NULL, 'es_ES');

--
-- Volcar la base de datos para la tabla `eda_usuarios`
--

INSERT INTO `eda_usuarios` VALUES(1, 1, 'root', 1, '2010-06-25', NULL, '2010-06-25 18:43:11', '2010-06-25 18:43:15', 'es_ES', 0, 1, NULL);

--
-- Volcar la base de datos para la tabla `gen_comunidades`
--


--
-- Volcar la base de datos para la tabla `gen_paises`
--


--
-- Volcar la base de datos para la tabla `gen_paises_i18n`
--


--
-- Volcar la base de datos para la tabla `gen_provincias`
--


--
-- Volcar la base de datos para la tabla `sf_guard_group`
--


--
-- Volcar la base de datos para la tabla `sf_guard_group_permission`
--


--
-- Volcar la base de datos para la tabla `sf_guard_permission`
--


--
-- Volcar la base de datos para la tabla `sf_guard_remember_key`
--


--
-- Volcar la base de datos para la tabla `sf_guard_user`
--

INSERT INTO `sf_guard_user` VALUES(1, 'root', 'sha1', '73588ae572ebaf06ef76424cf8d6ee76', '5c353fe76a036a2a891d9a79ded971fc0f4e5d43', '2010-06-25 18:42:14', NULL, 1, 1);

--
-- Volcar la base de datos para la tabla `sf_guard_user_group`
--


--
-- Volcar la base de datos para la tabla `sf_guard_user_permission`
--

