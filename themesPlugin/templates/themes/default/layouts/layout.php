<?php
/*
 * Copyright 2010 Instituto de Tecnologías Educativas - Ministerio de Educación de España
 *
 * Licencia con arreglo a la EUPL, Versión 1.1 exclusivamente
 * (la «Licencia»);
 * Solo podrá usarse esta obra si se respeta la Licencia.
 * Puede obtenerse una copia de la Licencia en:
 *
 * http://ec.europa.eu/idabc/eupl5
 *
 * y también en:

 * http://ec.europa.eu/idabc/en/document/7774.html
 *
 * Salvo cuando lo exija la legislación aplicable o se acuerde
 * por escrito, el programa distribuido con arreglo a la
 * Licencia se distribuye «TAL CUAL»,
 * SIN GARANTÍAS NI CONDICIONES DE NINGÚN TIPO, ni expresas
 * ni implícitas.
 * Véase la Licencia en el idioma concreto que rige
 * los permisos y limitaciones que establece la Licencia.
 */
?>
<?php slot('nav') ?>
<?php include_component('sfBreadNav', 'compMenu'); ?>
<?php end_slot(); ?>
<?php
$aplicacion = SftAplicacionPeer::dameAplicacionConClave(sfConfig::get('app_clave'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>

        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>

        <title><?php echo sfConfig::get('app_titulo') ?></title>
        <link rel="shortcut icon" href="/favicon.ico" />
    </head>
    <body>        
        <div id="contenedor_general">
            <?php include_partial('global/cabecera') ?>

            <div id="wrapper">
                <div id="perfil" class="personal">
                    <?php include_component('sftGestorSesion', 'compUsuario') ?>
                    <?php include_component('sftGestorSesion', 'compMenuGeneral') ?>
                </div>

                <h3><?php echo sfConfig::get('app_titulo') ?></h3>

                <div id="menuprincipal">
                    <?php include_slot('nav'); ?>
                    <?php  //include_component('sfBreadNav', 'compMenu') ?>
                    <?php //include_partial('sfBreadNav/navmenu', array('menu' => 'menu_'.$aplicacion->getCodigo())) ?>
                </div>

                <br/>
                <div id="breadnavbreadcrumbdiv">
                    <?php //include_partial('sfBreadNav/breadcrumb', array('menu' => 'menu_'.$aplicacion->getCodigo())) ?>
                </div>


                <?php echo $sf_content ?>

                </div>

                ﻿<?php include_partial('global/pie') ?>
        </div>
    </body>
</html>
