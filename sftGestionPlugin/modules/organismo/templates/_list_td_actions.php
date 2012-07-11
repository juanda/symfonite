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
<?php use_themes_javascript('jquery/js/jquery-1.6.2.min.js') ?>
<?php use_themes_javascript('colorbox/js/jquery.colorbox.js') ?>
<?php use_themes_stylesheet('colorbox/css/colorbox.css') ?>

<script>
    $(document).ready(function(){

        $(".emails").colorbox({iframe:true, width:1100, height:500,
        onClosed:function(){ location.reload(true);} });  
        $(".direcciones").colorbox({iframe:true, width:1100, height:500,
        onClosed:function(){ location.reload(true);} });  
        $(".telefonos").colorbox({iframe:true, width:1100, height:500,
        onClosed:function(){ location.reload(true);} }); 
        $(".atributos").colorbox({iframe:true, width:1100, height:500,
        onClosed:function(){ location.reload(true);} }); 
    });
</script>



<?php
$usuario = $SftOrganismo->dameSftUsuario(ESC_RAW);
if (is_object($usuario))
    $usuario = $usuario->getRawValue();
else
    $usuario = null;
?>
<td>
    <ul class="sf_admin_td_actions">
        <?php if ($sf_user->hasCredential('SFTGESTIONPLUGIN_administracion')) : ?>
            <?php echo $helper->linkToEdit($SftOrganismo, array('params' => array(), 'class_suffix' => 'edit', 'label' => 'Edit',)) ?>
            <?php echo $helper->linkToDelete($SftOrganismo, array('params' => array(), 'confirm' => 'Are you sure?', 'class_suffix' => 'delete', 'label' => 'Delete',)) ?>
        <?php endif; ?>
        <li class="sf_admin_action_asociaperfiles">
            <?php if ($usuario instanceof SftUsuario) : ?>
                <?php echo link_to(__('Perfiles', array(), 'messages'), 'sft_organismo_object' , array('id'=>  $usuario->getId(), 'action'=> 'ListAsociaPerfiles')) ?>
            <?php endif; ?>
            <?php
            if ($sf_user->hasCredential('SFTGESTIONPLUGIN_administracion'))
            {
                $id_uo = null;
            } else
            {
                $id_uo = $sf_user->getAttribute('idUnidadOrganizativa', null, 'SftUser');
            }
            ?>
            <?php if ($usuario->numeroPerfiles($id_uo) > 0) : ?>
                (<?php echo $usuario->numeroPerfiles($id_uo) ?>)
            <?php endif; ?>

        </li>

        <li class="sf_admin_action_emails">
            <?php echo link_to(__('E-mails', array(), 'messages'), '@sft_organismo_object?action=ListEmails&id=' . $usuario->getId(), array('class' => 'emails')) ?>
            <?php if ($usuario->numeroEmails() > 0) : ?>
                (<?php echo $usuario->numeroEmails($id_uo) ?>)
            <?php endif; ?>
        </li>
        
        <li class="sf_admin_action_direcciones">
            <?php echo link_to(__('Direcciones', array(), 'messages'), '@sft_organismo_object?action=ListDirecciones&id=' . $usuario->getId(), array('class' => 'direcciones')) ?>
            <?php if ($usuario->numeroDirecciones() > 0) : ?>
                (<?php echo $usuario->numeroDirecciones($id_uo) ?>)
            <?php endif; ?>
        </li>
        
        <li class="sf_admin_action_telefonos">
            <?php echo link_to(__('Teléfonos', array(), 'messages'), '@sft_organismo_object?action=ListTelefonos&id=' . $usuario->getId(), array('class' => 'telefonos')) ?>
            <?php if ($usuario->numeroTelefonos() > 0) : ?>
                (<?php echo $usuario->numeroTelefonos($id_uo) ?>)
            <?php endif; ?>
        </li>

        <li class="sf_admin_action_atributos">
            <?php if ($usuario instanceof SftUsuario) : ?>
                <?php echo link_to(__('Attributos', array(), 'messages'), '@sft_organismo_object?action=ListAtributos&id=' . $usuario->getId(), array('class' => 'atributos')) ?>
            <?php endif; ?>
            <?php if ($usuario->numeroAtributos() > 0) : ?>
            (<?php echo $usuario->numeroAtributos($id_uo) ?>)
            <?php endif; ?>

        </li>
    </ul>
</td>
