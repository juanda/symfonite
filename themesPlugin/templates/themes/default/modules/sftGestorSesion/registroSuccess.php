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
<div id="sf_admin_container">
    <div class="sf_admin_content">


        <?php if($sf_user -> hasFlash('mensaje')): ?>
        <div class="notice"><?php echo __($sf_user -> getFlash('mensaje')) ?></div>
        <?php endif; ?>
        <?php if($sf_user -> hasFlash('error')): ?>
        <div class="error"><?php echo __($sf_user -> getFlash('error')) ?></div>
        <?php endif; ?>


        <div class="caja_password">
            <div class="sf_admin_form">
                <form id="registro" name="registro" method="POST" action="<?php echo url_for('@sftGuardPlugin_enviarTokenRegistro')?>">
                    <?php echo $formRegistro -> renderGlobalErrors() ?>
                     <?php echo $formRegistro -> renderhiddenFields() ?>
                    <fieldset id="login">
                        <div  class="sf_admin_form_row sf_admin_text sf_admin_form_field_email">
                            <?php echo $formRegistro['email']->renderError() ?>
                            <div>
                                <label for="usuario"><?php echo __("E-mail:") ?></label>
                                <div class="content"><?php echo $formRegistro['email'] ->render(array('size' => '40')) ?></div>
                            </div>
                        </div>
                        <div  class="sf_admin_form_row sf_admin_text sf_admin_form_field_alias">
                            <?php echo $formRegistro['alias']->renderError() ?>
                            <div>
                                <label for="alias"><?php echo __("Alias:") ?></label>
                                <div class="content"><?php echo $formRegistro['alias'] ->render(array('size' => '40')) ?></div>
                            </div>
                        </div>
                        <div  class="sf_admin_form_row sf_admin_text sf_admin_form_field_username">
                            <?php echo $formRegistro['username']->renderError() ?>
                            <div>
                                <label for="username"><?php echo __("Nombre de usuario:") ?></label>
                                <div class="content"><?php echo $formRegistro['username'] ->render(array('size' => '40')) ?></div>
                            </div>
                        </div>
                        <div  class="sf_admin_form_row sf_admin_text sf_admin_form_field_password">
                            <?php echo $formRegistro['password']->renderError() ?>
                            <div>
                                <label for="password"><?php echo __("Contraseña:") ?></label>
                                <div class="content"><?php echo $formRegistro['password'] ->render(array('size' => '40')) ?></div>
                            </div>
                        </div>
                        <div  class="sf_admin_form_row sf_admin_text sf_admin_form_field_repassword">
                            <?php echo $formRegistro['repassword']->renderError() ?>
                            <div>
                                <label for="repassword"><?php echo __("Repite la contraseña:") ?></label>
                                <div class="content"><?php echo $formRegistro['repassword'] ->render(array('size' => '40')) ?></div>
                            </div>
                        </div>
                    </fieldset>
                    <input type="submit" name="enviar" id="enviar"/>

                </form>
            </div>
        </div>
    </div>
</div>

