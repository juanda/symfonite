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

<?php if(!is_null($linkPerfiles)): ?>
| <span class="cambiar_perfil_ico"><a href="<?php echo $linkPerfiles ?>"><?php echo __('cambiar perfil') ?></a></span>
<?php endif; ?>

<?php if(!is_null($linkConfiguracionPersonal)): ?>
| <span class="conf_personal_ico"><a href="<?php echo $linkConfiguracionPersonal ?>"><?php echo __('configuración personal') ?></a></span>
<?php endif; ?>

<?php if(!is_null($linkAplicaciones)): ?>
| <span class="aplicaciones_ico"><a href="<?php echo $linkAplicaciones ?>"><?php echo __('aplicaciones') ?></a></span>
<?php endif; ?>

<?php if(!is_null($linkAyuda)): ?>
| <span class="ayuda_ico"><a href="#" id="Ayuda" name="Ayuda" title="Ver Ayuda" onclick="ventanaNueva('<?php echo $linkAyuda?>','Ayuda','scrollbars=yes,width=790,height=595,top=0,left=0')" onmouseover="javascript:{window.status='Ver Ayuda';return true;}"><?php echo __('ayuda') ?></a></span>
<?php endif; ?>

<?php if(!is_null($linkDesconectar)): ?>
| <span class="logout_ico"><a href="<?php echo $linkDesconectar ?>"><?php echo __('salir') ?></a></span>
<?php endif; ?>