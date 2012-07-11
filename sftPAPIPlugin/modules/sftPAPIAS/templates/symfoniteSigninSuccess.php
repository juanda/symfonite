<?php use_helper('I18N') ?>
<?php use_themes_stylesheet('native/css/default.css') ?>

<div id="sf_admin_container">
    <h1>PAPI Authentication Service</h1>


    <div class="texto_intro">
        <?php echo _('This is the example lofin form of the symfony PAPI plugin. ') ?>
        <br/>
        <?php echo _('If needed, you can change it. In the documentation you can
            find an explanation to do it.') ?>
    </div>

    <h1><?php echo __('session init')?></h1>
    <div class="caja_login">
        <div class="sf_admin_form">
            <?php if ($sf_user->hasFlash('message')): ?>
                <div class="error"><?php echo __($sf_user->getFlash('message')) ?></div>
            <?php endif; ?>

                <form name="f" action="<?php echo url_for('@papi_signin') ?> " method="post" >
                <?php echo $form->renderHiddenFields(false) ?>
                <?php include_partial('sftPAPIAS/papi_params') ?>

                <?php if ($form->hasGlobalErrors()): ?>
                <?php echo $form->renderGlobalErrors() ?>
                <?php endif; ?>

                    <fieldset>
                        <div class="sf_admin_form_row">
                        <?php if ($form['username']->hasError()) : ?>
                            <li>
                            <?php echo $form['username']->renderError() ?>
                        </li>
                        <?php endif; ?>
                            <div>
                                <label for="username"><?php echo $form['username']->renderLabel() ?></label>
                                <div class="content"><?php echo $form['username'] ?></div>
                            </div>
                        </div>

                        <div class="sf_admin_form_row">
                        <?php if ($form['password']->hasError()) : ?>
                                <li>
                            <?php echo $form['password']->renderError() ?>
                            </li>
                        <?php endif; ?>
                                <div>
                                    <label for="password"><?php echo $form['password']->renderLabel() ?></label>
                                    <div class="content"><?php echo $form['password'] ?></div>
                        </div>
                    </div>
                </fieldset>


                <ul class="sf_admin_actions">
                    <li>
                        <input type="submit" value="<?php echo _('Continue')?>" />
                    </li>
                </ul>
            </form>
        </div>

    </div>
</div>



