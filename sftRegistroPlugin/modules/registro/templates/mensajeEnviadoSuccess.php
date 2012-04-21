<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="sf_admin_container">

    <div id="sf_admin_header">
        <h2><?php echo __('Registro en symfonite') ?></h2>
        <?php if($sf_user -> hasFlash('mensaje')): ?>
        <div class="notice"><?php echo __($sf_user -> getFlash('mensaje')) ?></div>
        <?php endif; ?>
        <?php if($sf_user -> hasFlash('error')): ?>
        <div class="error"><?php echo __($sf_user -> getFlash('error')) ?></div>
        <?php endif; ?>
    </div>

    
    <a href="<?php echo url_for('@homepage')?>">Volver a la página principal</a>

</div>