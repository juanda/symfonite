<?php use_helper('I18N', 'Date') ?>
<?php include_partial('aplicacion/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Edición de la Aplicación: %%NOMBRE%%', array('%%NOMBRE%%' => $SftAplicacion->getNOMBRE()), 'messages') ?></h1>

  <?php include_partial('aplicacion/flashes') ?>
  <?php if($sf_user->hasFlash('notice2')):?>
  <div class="hint">
      <?php echo $sf_user->getFlash('notice2')?>
  </div>
  <?php endif;?>
  
  <div id="sf_admin_header">
    <?php include_partial('aplicacion/form_header', array('SftAplicacion' => $SftAplicacion, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('aplicacion/form', array('SftAplicacion' => $SftAplicacion, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('aplicacion/form_footer', array('SftAplicacion' => $SftAplicacion, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
