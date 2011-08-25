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
<div class="error_alerta"> 

<?php echo image_tag('../ActivosPlugin/images/lock48.png', 'style="float:left;margin-right:20px"') ?>

 <h1>Credenciales requeridas</h1>
    <h5>Esta p&aacute;gina est&aacute; en un &aacute;rea restringida.</h5>


</div>


<dl class="error_info">
  <dt>No tienes las credenciales apropiadas para acceder a esta p&aacute;gina</dt>
  <dd>Aunque ya tienes acceso, esta p&aacute;gina requiere credenciales especiales que actualemten no posees.</dd>

  <dt>C&oacute;mo acceder a esta p&aacute;gina</dt>
  <dd>Debes pedirle al administraror del sitio que te conceda credenciales especiales</dd>

  <br/>
  <dd>
    <ul class="sfTIconList">
      <li class="sfTLinkMessage"><a href="javascript:history.go(-1)">Volver a la p&aacute;gina anterior</a></li>
    </ul>
  </dd>
</dl>
