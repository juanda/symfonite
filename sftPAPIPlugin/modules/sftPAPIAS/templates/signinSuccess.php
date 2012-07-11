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
<?php use_helper('I18N') ?>
<?php if ($sf_user->hasFlash('message')): ?>
    <div class="notice"><?php echo __($sf_user->getFlash('message')) ?></div>
<?php endif; ?>

    <form name="f" action="<?php echo url_for('@papi_signin') ?> " method="post" >
    <?php echo $form ?>
    <?php    include_partial('sftPAPIAS/papi_params') ?>
    <input type="submit" value="Continuar" />
</form>