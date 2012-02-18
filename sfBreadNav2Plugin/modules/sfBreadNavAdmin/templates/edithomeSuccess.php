<?php use_helper('I18N') ?>


<div id="sf_admin_container">
    <h1>Item de inicio de la aplicación: <?php echo $aplicacion->getNombre() ?></h1>

    <div id="sf_admin_header">
    </div>

    <div class="sf_admin_form">
        <form action="" method='POST'>
            <?php echo $form->renderGlobalErrors() ?>
            <?php echo $form->renderHiddenFields() ?>
            <fieldset id="sf_fieldset_1">
                <h2><?php echo __('Item de inicio') ?></h2>

                <div class="sf_admin_form_row">
                    <div>
                        <label for="textedit2"><?php echo __('página') ?></label>
                        <?php echo $form['page']->renderError() ?>
                        <?php echo $form['page'] ?>
                    </div>
                </div>

                <div class="sf_admin_form_row">
                    <div>
                        <label for="textedit2"><?php echo __('módulo') ?></label>
                        <?php echo $form['module']->renderError() ?>
                        <?php echo $form['module'] ?>
                    </div>
                </div>

                <div class="sf_admin_form_row">
                    <div>
                        <label for="textedit2"><?php echo __('acción') ?></label>
                        <?php echo $form['action']->renderError() ?>
                        <?php echo $form['action'] ?>
                    </div>
                </div>

                <div class="sf_admin_form_row">
                    <div>
                        <label for="textedit2"><?php echo __('credencial') ?></label>
                        <?php echo $form['credential']->renderError() ?>
                        <?php echo $form['credential'] ?>
                    </div>
                </div>

                <div class="sf_admin_form_row">
                    <div>
                        <label for="textedit2"><?php echo __('catch all') ?></label>
                        <?php echo $form['catch_all']->renderError() ?>
                        <?php echo $form['catch_all'] ?>
                    </div>
                </div>

            </fieldset>


            <ul class="sf_admin_actions">
                <li><input type='submit' value='<?php echo __('Guardar')?>' /></li>
            </ul>
        </form>
    </div>

</div>