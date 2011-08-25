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
<?php include_partial('ambitos/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Nuevo Ámbito del tipo', array(), 'messages') ?> <i><?php echo $ambitotipo -> getNombre() ?></i></h1>

  <?php include_partial('ambitos/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('ambitos/form_header', array('EdaAmbitos' => $EdaAmbitos, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('ambitos/form', array('EdaAmbitos' => $EdaAmbitos, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('ambitos/form_footer', array('EdaAmbitos' => $EdaAmbitos, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
