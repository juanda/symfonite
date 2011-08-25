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
    <h1><?php echo __('Listado de Ámbitos del tipo', array(), 'messages') ?> <i><?php echo $ambitotipo -> getNombre() ?></i></h1>

  <?php include_partial('ambitos/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('ambitos/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('ambitos/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('eda_ambitos_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('ambitos/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('ambitos/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('ambitos/list_actions', array('helper' => $helper, 'ambitotipo' => $ambitotipo)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('ambitos/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
