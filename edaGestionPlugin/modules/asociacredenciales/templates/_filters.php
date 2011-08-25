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
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="sf_admin_filter">
    <?php if ($form->hasGlobalErrors()): ?>
        <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

    <?php
     $query_string= ($sf_request -> hasParameter('asociacred'))?
             '?id_perfil='.$sf_request -> getParameter('id_perfil').'&asociacred=true' :
             '?id_perfil='.$sf_request -> getParameter('id_perfil').'&vercred=true';
      ?>
    
    <form action="<?php echo url_for('asociacredenciales/filter'.$query_string, array('action' => 'filter')) ?>" method="post">
        <table cellspacing="0">
            <tfoot>
                <tr>
                    <td colspan="2">
                            <?php echo $form->renderHiddenFields() ?>
                            
                        <input type="submit" value="<?php echo __('Filter', array(), 'sf_admin') ?>" />
                    </td>
                </tr>
            </tfoot>
            <tbody>
                    <?php foreach ($configuration->getFormFilterFields($form) as $name => $field): ?>
                        <?php if (($name == 'eda_perfil_credencial_list') || (isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?>
                        <?php include_partial('asociacredenciales/filters_field', array(
                                'name'       => $name,
                                'attributes' => $field->getConfig('attributes', array()),
                                'label'      => $field->getConfig('label'),
                                'help'       => $field->getConfig('help'),
                                'form'       => $form,
                                'field'      => $field,
                                'class'      => 'sf_admin_form_row sf_admin_'.strtolower($field->getType()).' sf_admin_filter_field_'.$name,
                                )) ?>
                    <?php endforeach; ?>

            </tbody>
        </table>
    </form>
</div>
