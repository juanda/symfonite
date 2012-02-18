<?php use_helper('I18N', 'Date') ?>
<?php include_partial('persona/assets') ?>
<?php use_themes_javascript('jquery/js/jquery-1.6.2.min.js') ?>
<?php use_themes_javascript('colorbox/js/jquery.colorbox.js') ?>
<?php use_themes_stylesheet('colorbox/css/colorbox.css') ?>

<script>
    $(document).ready(function(){

        $(".emails").colorbox({iframe:true, width:1100, height:500});  
        $(".direcciones").colorbox({iframe:true, width:1100, height:500});  
        $(".telefonos").colorbox({iframe:true, width:1100, height:500});  
    });
</script>

<div id="sf_admin_container">
  <h1><?php echo __('Edición de la persona: %%NOMBRE%% %%APELLIDO1%% %%APELLIDO2%%', array('%%NOMBRE%%' => $SftPersona->getNOMBRE(), '%%APELLIDO1%%' => $SftPersona->getAPELLIDO1(), '%%APELLIDO2%%' => $SftPersona->getAPELLIDO2()), 'messages') ?></h1>

  <?php include_partial('persona/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('persona/form_header', array('SftPersona' => $SftPersona, 'form' => $form, 'configuration' => $configuration)) ?>      
  </div>

  <div id="sf_admin_content">
      <ul class="sf_admin_td_actions">
      <li class="sf_admin_action_emails">
            <?php echo link_to(__('E-mails', array(), 'messages'), 'persona/ListEmails?id=' . $SftPersona->dameSftUsuario()->getId(), array('class' => 'emails')) ?>
        </li>
        
        <li class="sf_admin_action_direcciones">
            <?php echo link_to(__('Direcciones', array(), 'messages'), 'persona/ListDirecciones?id=' . $SftPersona->dameSftUsuario()->getId(), array('class' => 'direcciones')) ?>
        </li>
        
        <li class="sf_admin_action_telefonos">
            <?php echo link_to(__('Teléfonos', array(), 'messages'), 'persona/ListTelefonos?id=' . $SftPersona->dameSftUsuario()->getId(), array('class' => 'telefonos')) ?>
        </li>
      </ul>
      <hr/>
    <?php include_partial('persona/form', array('SftPersona' => $SftPersona, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('persona/form_footer', array('SftPersona' => $SftPersona, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
