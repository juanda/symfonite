<?php use_javascript('../ActivosPlugin/js/colorbox/jquery.colorbox.js') ?>
<?php use_stylesheet('../ActivosPlugin/css/colorbox.css') ?>

<script>
<?php if($sf_user -> hasAttribute('nombreCajaTexto')): ?>
    parent.$("<?php echo '#'.$sf_user -> getAttribute('nombreCajaTexto') ?>").attr('value', '<?php echo $nombre ?>');
<?php endif; ?>
    <?php if($sf_user -> hasAttribute('nombreCajaHidden')): ?>
        parent.$("<?php echo '#'.$sf_user -> getAttribute('nombreCajaHidden') ?>").attr('value', '<?php echo $idUsuario ?>');
<?php endif; ?>

        parent.$.fn.colorbox.close();
</script>
