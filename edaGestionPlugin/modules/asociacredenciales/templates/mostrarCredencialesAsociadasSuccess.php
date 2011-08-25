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
<?php use_helper('jQuery') ?>

<table>
    <th><?php echo __("nombre")?></th>
    <th><?php echo __("descripcion")?></th>
    <th><?php echo __("aplicación")?></th>
    <?php foreach ($credenciales as $credencial): ?>
    <tr>
        <td><?php echo $credencial -> getNombre() ?> </td>
        <td><?php echo $credencial -> getDescripcion() ?></td>
        <td><?php echo $credencial -> getEdaAplicaciones() -> getNombre() ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if(count($credenciales) == 0): ?>
    <tr>
    <td colspan="3"><?php echo __("Este perfil no tiene credenciales asociadas para los términos de la búsqueda")?></td>
    </tr>
    <?php endif; ?>

</table>

