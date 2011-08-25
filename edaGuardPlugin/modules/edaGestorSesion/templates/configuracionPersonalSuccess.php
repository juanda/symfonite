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
<h1><?php echo __("Configuración personal",null,"configper")?></h1  >
<?php $sf_user -> setFlash('notice', __($aviso,null,'configper')) ?>
<div id="sf_admin_container">
    
    <?php if ($sf_user->hasFlash('notice') && $sf_user -> getFlash('notice') != ''): ?>
    <div class="notice"><?php echo __($sf_user->getFlash('notice'), array(), 'sf_admin') ?></div>
    <?php endif; ?>

    <?php if ($sf_user->hasFlash('error')): ?>
    <div class="error"><?php echo __($sf_user->getFlash('error'), array(), 'sf_admin') ?></div>
    <?php endif; ?>
    <div class="sf_admin_content">
        <div class="sf_admin_form">

           

            <form action="<?php echo url_for("edaGestorSesion/configuracionPersonal?form=pass")?>" method="post">
                <fieldset id="sf_fieldset_password" >
                    <h2><?php echo __("Cambiar la contraseña",null,"configper")?></h2>
                    <div class="sf_admin_form_row">
                        <label><?php echo __("Nueva contraseña:",null,"configper")?></label>
                        <?php echo $formularioPass['password']->renderError()?><?php echo $formularioPass['password']?>
                    </div>
                    <div class="sf_admin_form_row">
                        <label><?php echo __("Repita la nueva contraseña:",null,"configper")?></label>
                        <?php echo $formularioPass['password_again']->renderError()?><?php echo $formularioPass['password_again']?>
                        <input type="submit" value="<?php echo __("Cambiar",null,"configper")?>" />
                    </div>
                </fieldset>               
            </form>

            <form action="<?php echo url_for("edaGestorSesion/configuracionPersonal?form=lang")?>" method="post">
                <fieldset id="sf_fieldset_cultura" >
                    <h2><?php echo __("Cambiar el Idioma",null,"configper")?></h2>
                    <div class="sf_admin_form_row">
                        <label><?php echo __("Elija el nuevo idioma:",null,"configper")?></label>
                        <?php echo $formularioUsuarios['id_culturapref']->renderError()?><?php echo $formularioUsuarios['id_culturapref']?>
                        <input type="submit" value="<?php echo __("Cambiar",null,"configper")?>" />
                    </div>
                </fieldset>
            </form>

            
                <fieldset id="perfil_por_defecto">
                    <h2>Cambio de Perfil/Selección Perfil por defecto</h2>
                    <?php include_component('edaGestorSesion','compPerfiles') ?>
                </fieldset>

        
        </div>
    </div>
</div>