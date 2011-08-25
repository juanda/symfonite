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
<td class="sf_admin_text sf_admin_list_td_logotipo">
<?php echo image_tag('/uploads/'. $EdaAplicaciones -> getLogotipo(), array('width' => '35')) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_nombre">
    
    <?php echo $EdaAplicaciones->getNombre() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_url_link">
    <a href="<?php echo $EdaAplicaciones->getUrl() ?>" target="_blank">
        <?php echo $EdaAplicaciones->getUrl() ?>
    </a>
</td>
<td class="sf_admin_text sf_admin_list_td_clave">
    <?php echo $EdaAplicaciones->getClave() ?>
</td>
