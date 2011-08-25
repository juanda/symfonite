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

    <div id="sf_admin_header">
        <h2><?php echo __('Reinicio de Password') ?></h2>
        <?php if($sf_user -> hasFlash('mensaje')): ?>
        <div class="notice"><?php echo __($sf_user -> getFlash('mensaje')) ?></div>
        <?php endif; ?>
        <?php if($sf_user -> hasFlash('error')): ?>
        <div class="error"><?php echo __($sf_user -> getFlash('error')) ?></div>
        <?php endif; ?>
    </div>
    
    <?php if($showForm): ?>

    <h2>Hola <i><?php echo $nombre ?></i>. Rellene este formulario y envíelo para cambiar su password.</h2>
    <form id="formCambioPassword" name="formCambioPassword" method="post" action="<?php echo url_for('edaGestorSesion/cambiarPassword?'.$queryString) ?>" >
        <?php echo $formPassword -> renderGlobalErrors() ?>
        <?php echo $formPassword -> renderHiddenFields() ?>
        <table>
            <tr>
                <th>
                    <?php echo $formPassword['password'] -> renderLabel() ?>:
                </th>
                <td>
                    <?php echo $formPassword['password'] -> renderError() ?>
                    <?php echo $formPassword['password'] -> render() ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $formPassword['password_again'] -> renderLabel() ?>:
                </th>
                <td>
                    <?php echo $formPassword['password_again'] -> renderError() ?>
                    <?php echo $formPassword['password_again'] -> render() ?>
                </td>
            </tr>           
        </table>
        
        <input id="cambiarPassword" name="cambiarPassword" type="submit" />

    </form>

    <?php endif; ?>

    <a href="<?php echo url_for('@homepage')?>">Volver a la página principal</a>

</div>
