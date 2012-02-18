<?php use_helper('I18N') ?>
<?php use_themes_javascript('jquery/js/jquery-1.6.2.min.js') ?>
<?php use_themes_javascript('colorbox/js/jquery.colorbox.js') ?>
<?php use_themes_stylesheet('colorbox/css/colorbox.css') ?>


<script>
    $(document).ready(function(){

        $(".samladmin").colorbox({iframe:true, width:1100, height:700 });  
        $(".samladmin").click();
        
        });
</script>

<div id="sf_admin_container">
    <h1><?php echo __('Acceso a la administración SAML') ?></h1>


    <ul class="sf_admin_td_actions">
        <li class="sf_admin_action_list"><a class="samladmin" href="<?php echo $urladminsaml ?>"><?php echo __('Administración simpleSAML') ?></a></li>

    </ul>
    <div class="sf_admin_content">

    </div>
</div>