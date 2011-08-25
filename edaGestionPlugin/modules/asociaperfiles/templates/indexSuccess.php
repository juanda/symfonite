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
<?php use_helper('I18N', 'Date') ?>
<?php use_helper('jQuery') ?>
<?php include_partial('asociaperfiles/assets') ?>

<div id="sf_admin_container">
    <h1><?php echo __('Selección de Perfiles del usuario', array(), 'messages') ?>: <?php echo $usuario  ?></h1>

    <?php include_partial('asociaperfiles/flashes') ?>

    <div id="sf_admin_header">
        <?php include_partial('asociaperfiles/list_header', array('pager' => $pager)) ?>
    </div>

    <div id="seleccion_perfiles">
        
       
            <h2>Selección de perfiles</h2>
            <div id="sf_admin_bar">
                <?php include_partial('asociaperfiles/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
            </div>



            <div id="sf_admin_content">

                <?php include_partial('asociaperfiles/list', array(
                        'pager'   => $pager,
                        'sort'    => $sort,
                        'helper'  => $helper,
                        'usuario' => $usuario)) ?>


            </div>

            <div id="sf_admin_footer">
                <?php include_partial('asociaperfiles/list_footer', array('pager' => $pager)) ?>
            </div>
        
    </div>
</div>
