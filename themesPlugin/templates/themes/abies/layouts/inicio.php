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
<!DOCTYPE html>
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_stylesheets() ?>

        <title><?php echo sfConfig::get('app_titulo') ?></title>
        <link rel="shortcut icon" href="/favicon.ico" />
    </head>
    <body>
        <div id="contenedor_general">
            <?php include_partial('global/cabecera') ?>
            <div id="wrapper">
    <h2><?php echo sfConfig::get('app_titulo') ?></h2>

<div id="login">
                <?php echo $sf_content ?>
 </div>
            </div>

            ﻿<?php include_partial('global/pie') ?>
        </div>
    </body>
</html>
