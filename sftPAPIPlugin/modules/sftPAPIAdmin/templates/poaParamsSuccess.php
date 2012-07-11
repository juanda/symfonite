<?php use_helper('I18N') ?>

<div id="sf_admin_container">
    <h1><?php echo __('Parámetros del Punto de Acceso (PoA)') ?></h1>

    <div id="sf_admin_header">
        <?php if ($sf_user->hasFlash('mensaje')): ?>
            <div class="notice">
                <?php echo $sf_user->getFlash('mensaje') ?>
            </div>
        <?php endif; ?>

        <?php if ($sf_user->hasFlash('error1')): ?>
            <div class="error">
                <?php echo $sf_user->getFlash('error1') ?>
            </div>
        <?php endif; ?>
        
        <?php if ($sf_user->hasFlash('error2')): ?>
            <div class="error">
                <?php echo $sf_user->getFlash('error2') ?>
            </div>
        <?php endif; ?>
    </div>

    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <form name="form" action="<?php echo url_for('@sftPAPIPlugin_poaParams') ?>" method="post">
                <?php echo $form->renderHiddenFields() ?>
                <?php echo $form->renderGlobalErrors() ?>

                <fieldset id="sf_fieldset_1">                    

                    <div class="sf_admin_form_row">
                        <div>
                            <label for="redirecturl"><?php echo __('Url del AS') ?></label>
                            <?php echo $form['redirecturl']->renderError() ?>
                            <?php echo $form['redirecturl']->render() ?>
                        </div>
                    </div>

                    <div class="sf_admin_form_row">
                        <div>
                            <label for="pubkey"><?php echo __('clave pública') ?></label>
                            <?php echo $form['pubkey']->renderError() ?>
                            <?php echo $form['pubkey']->render() ?>
                        </div>
                    </div>

                </fieldset>


                <ul class="sf_admin_actions">
                    <input type="submit" value="<?php echo __('Grabar') ?>"/>
                </ul>
            </form>
        </div>
    </div>

    <div id="sf_admin_footer">
    </div>
</div>