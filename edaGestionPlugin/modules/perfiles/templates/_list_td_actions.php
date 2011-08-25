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
<?php use_javascript('../ActivosPlugin/js/colorbox/jquery.colorbox.js') ?>
<?php use_stylesheet('../ActivosPlugin/css/colorbox.css') ?>

<script>
    $(document).ready(function(){

        $(".asociacredenciales").colorbox({iframe:true, width:1100, height:500});
        $(".vercredenciales").colorbox({iframe:true, width:1100, height:500});
    });
</script>

<td>
    <ul class="sf_admin_td_actions">
        <?php echo $helper->linkToEdit($EdaPerfiles, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
        <?php echo $helper->linkToDelete($EdaPerfiles, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
        <li class="sf_admin_action_asociacredenciales">
            <?php echo link_to(__('Asoc. Creds.', array(), 'messages'), 'perfiles/ListAsociaCredenciales?id='.$EdaPerfiles->getId(), array('class' => 'asociacredenciales')) ?>
            <?php echo link_to(__('Ver Creds.', array(), 'messages'), 'perfiles/ListVerCredenciales?id='.$EdaPerfiles->getId(), array('class' => 'vercredenciales')) ?>
        </li>
    </ul>
</td>
