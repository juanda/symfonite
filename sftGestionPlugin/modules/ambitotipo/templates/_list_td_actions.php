<?php use_themes_javascript('jquery/js/jquery-1.6.2.min.js') ?>
<?php use_themes_javascript('colorbox/js/jquery.colorbox.js') ?>
<?php use_themes_stylesheet('colorbox/css/colorbox.css') ?>

<script>
    $(document).ready(function(){

        $(".gestionarambitos").colorbox({iframe:true, width:1100, height:500});        
    });
</script>


<td>
    <ul class="sf_admin_td_actions">
        <?php echo $helper->linkToEdit($SftAmbitoTipo, array('params' => array(), 'class_suffix' => 'edit', 'label' => 'Edit',)) ?>
        <?php echo $helper->linkToDelete($SftAmbitoTipo, array('params' => array(), 'confirm' => 'Are you sure?', 'class_suffix' => 'delete', 'label' => 'Delete',)) ?>   
        <li class="sf_admin_action_ambitos">
            <?php echo link_to(__('Ámbitos', array(), 'messages'), 'ambitotipo/ListGestionarAmbitos?id=' . $SftAmbitoTipo->getId(), array('class' => 'gestionarambitos')) ?>
        </li>
    </ul>
</td>



