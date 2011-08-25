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

  <?php echo image_tag('../ActivosPlugin/images/cancel48.png', 'style="float:left;margin-right:20px"') ?>
    <h1>&iexcl;Ups! P&aacute;gina No Encontrada</h1>
    <h5>El servidor ha respondido con un mensaje 404.</h5>



</div>

<dl class="error_info">
  <dt>&iquest;Has escrito t&uacute; la URL?</dt>
  <dd>Puedes haber tecleado la direcci&oacute;n (URL) incorrectamente. Aseg&uacute;rate de que lo has escrito exactamente, may&uacute;sculas, etc...</dd>

  <dt>&iquest;Has llegado a este este enlace desde otra p&aacute;gina de esta web?</dt>
  <dd>Si has llegado a esta p&aacute;gina desde otra parte de la web, por favor, escr&iacute;benos a <?php echo mail_to('[email]') ?> para que podamos corregir el error.
  </dd>

  <dt>&iquest;Has llegado a este enlace desde otra esta web?</dt>
  <dd>Los enlaces desde otros sitios web pueden estar anticuados o mal escritos. Escr&iacute;benos a <?php echo mail_to('[email]') ?> indic&aacute;ndonos la p&aacute;gina desde la que seguiste el enlace para que podamos corregir el problema.</dd>

  <dt>Siguiente</dt>
  <dd>
    <ul class="sfTIconList">
      <li class="sfTLinkMessage"><a href="javascript:history.go(-1)">Volver a la p&aacute;gina anterior</a></li>
    </ul>
  </dd>
</dl>








