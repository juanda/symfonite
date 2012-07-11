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
<?php if($sf_user -> hasFlash('mensaje')): ?>
<div class="notice"><?php echo __($sf_user -> getFlash('mensaje')) ?></div>
<?php endif; ?>
<?php if($sf_user -> hasFlash('error')): ?>
<div class="error"><?php echo __($sf_user -> getFlash('error')) ?></div>
<?php endif; ?>

<?php if($muestraFormLogin): ?>



<div id="formulario_login" class="formulario_login">

    <div class="sf_admin_form">
        <form name="formLogin" id="formLogin" action="<?php echo url_for('@login') ?> " method="post" >

            <div id="errores_globales" class="error" >
                        <?php echo $form->renderGlobalErrors() ?>
            </div>

            <fieldset id="login">
                <div  class="sf_admin_form_row sf_admin_text sf_admin_form_field_username">
                            <?php echo $form['username']->renderError() ?>
                    <div>
                        <label for="usuario"><?php echo __("Usuario:") ?></label>
                        <div class="content"><?php echo $form['username'] ?></div>
                    </div>
                </div>

                <div  class="sf_admin_form_row sf_admin_text sf_admin_form_field_password">
                            <?php echo $form['password']->renderError() ?>
                    <div>
                        <label for="password"><?php echo __("Clave:") ?></label>
                        <div class="content"><?php echo $form['password'] ?></div>
                    </div>
                </div>

                <div  class="sf_admin_form_row sf_admin_text sf_admin_form_field_remember">
                            <?php echo $form['remember']->renderError() ?>
                    <div>
                        <label for="remember"><?php echo __("Recuérdame:") ?></label>
                        <div class="content"><?php echo $form['remember'] ?></div>
                    </div>

                </div>
            </fieldset>

                    <?php echo $form->renderHiddenFields() ?>
            <ul class="sf_admin_actions">
                <li class="sf_admin_action_list">
                    <input type="submit" value="<?php echo __("Entrar") ?>" class="botton"/>
                </li>
            </ul>
        </form>
    </div>
  
</div>

<?php endif; ?>