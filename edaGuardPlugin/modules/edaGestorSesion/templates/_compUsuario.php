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
<?php use_helper('I18N')  ?>
<?php if($sf_user -> hasFlash('errorServicio')): ?>
<div class="error">
        <?php echo $sf_user -> getFlash('errorServicio') ?>
</div>
<?php endif; ?>

<span class="perfil">
    <?php if(isset($nombre)) : ?>
    <i class="user_ico"><?php echo __($nombre) ?></i>
    <?php endif; ?>

    <?php if(isset($perfil)) : ?>
    | <i class="profile_ico"><?php echo __($perfil) ?></i>
    <?php endif; ?>

    <?php if(isset($ambito)) : ?>
    : <i><?php echo __($ambito) ?></i>
    <?php endif; ?>

    <?php if(isset($uo)) : ?>
    | <i class="uo_ico"><?php echo __($uo) ?></i>
    <?php endif; ?>

    <?php if(isset($periodo)) : ?>
    | Ejercicio: <i><?php echo __($periodo) ?></i>
    <?php endif; ?>
</span>
