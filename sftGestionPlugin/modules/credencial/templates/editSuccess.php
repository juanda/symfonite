<?php use_helper('I18N', 'Date') ?>
<?php include_partial('credencial/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Edición de la Credencial: "%%NOMBRE%%", de la aplicacion: "%%NombreAplicacion%%"', array('%%NOMBRE%%' => $SftCredencial->getNOMBRE(), '%%NombreAplicacion%%'=>$aplicacion->getNombre()), 'messages') ?></h1>

  <?php include_partial('credencial/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('credencial/form_header', array('SftCredencial' => $SftCredencial, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('credencial/form', array('SftCredencial' => $SftCredencial, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('credencial/form_footer', array('SftCredencial' => $SftCredencial, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
