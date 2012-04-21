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
        <h2><?php echo __('Registro completado con éxito.') ?></h2>
        <?php if($sf_user -> hasFlash('mensaje')): ?>
        <div class="notice"><?php echo __($sf_user -> getFlash('mensaje')) ?></div>
        <?php endif; ?>
        <?php if($sf_user -> hasFlash('error')): ?>
        <div class="error"><?php echo __($sf_user -> getFlash('error')) ?></div>
        <?php endif; ?>
    </div>

    
    <a href="<?php echo url_for('@homepage')?>">Volver a la página principal</a>

</div>