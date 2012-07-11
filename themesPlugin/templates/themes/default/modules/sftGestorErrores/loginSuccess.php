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
<?php decorate_with(dirname(__FILE__).'/defaultLayout.php') ?>



<div class="error_alerta"> 

  <img src="/aurelio/repositorioActividades/web/sf/sf_default/images/icons/lock48.png"  / style="float:left;margin-right:20px;" >
 <h1>Registro necesario</h1>
    <h5>Esta p&aacute;gina no es p&uacute;blica.</h5>


</div>







<dl class="error_info">
  <dt>Para acceder a esta p&aacute;gina</dt>
  <dd>Accede a la p&aacute;gina de acceso e introduce tu nombre de usuario y contrase&ntilde;a.</dd>

  <dt>Siguiente</dt>
  <dd>
    <ul class="sfTIconList">
      <li class="sfTLinkMessage"><?php echo link_to('Ir a la p&aacute;gina de acceso', '@login') ?></li>
      <li class="sfTLinkMessage"><a href="javascript:history.go(-1)">Volver a la p&aacute;gina anterior</a></li>
    </ul>
  </dd>
</dl>
