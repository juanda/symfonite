<?php use_helper('I18N', 'Date') ?>
<?php include_partial('asociaatributos/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Edición del Atributo %%EdaUsuAtributos%%', array('%%EdaUsuAtributos%%' => $EdaUsuAtributosValores->getEdaUsuAtributos()), 'messages') ?>
      <?php if (isset($EdaUsuAtributosValores)){echo __(' del usuario '.$EdaUsuAtributosValores->getNombreUsuario(), array(),'messages');} ?>
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
