<?php use_helper('I18N', 'Date') ?>
<?php include_partial('asociaatributos/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Crear un nuevo atributo', array(), 'messages') ?>
      <?php if (isset($nombreUsuario)){echo __(' del usuario '.$nombreUsuario, array(),'messages');} ?>
  </h1>

  <?php include_partial('asociaatributos/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('asociaatributos/form_header', array('EdaUsuAtributosValores' => $EdaUsuAtributosValores, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('asociaatributos/form', array('EdaUsuAtributosValores' => $EdaUsuAtributosValores, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('asociaatributos/form_footer', array('EdaUsuAtributosValores' => $EdaUsuAtributosValores, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>

