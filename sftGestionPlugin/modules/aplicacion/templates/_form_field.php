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
<?php if ($field->isPartial()): ?>
    <?php include_partial('aplicaciones/'.$name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php elseif ($field->isComponent()): ?>
    <?php include_component('aplicaciones', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php else: ?>
<div class="<?php echo $class ?><?php $form[$name]->hasError() and print ' errors' ?>">
        <?php echo $form[$name]->renderError() ?>
    <div>
            <?php echo $form[$name]->renderLabel($label) ?>
            <?php if($name == 'clave'): ?>

        <ul class="sf_admin_actions">
            <li class="sf_admin_action_clave">
                        <?php echo jq_link_to_remote('generar clave',
                        array(
                        //'update'  => 'sft_aplicaciones_clave',
                        'url'     => 'aplicacion/generaClave',
                        'success' => "jQuery('#sft_aplicacion_clave').attr('value', data)"
                        )) ?>
            </li>
        </ul>

            <?php endif; ?>

        <div class="content">

                <?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?>
        </div>


            <?php if ($help): ?>
        <div class="help"><?php echo __($help, array(), 'messages') ?></div>
            <?php elseif ($help = $form[$name]->renderHelp()): ?>
        <div class="help"><?php echo $help ?></div>
            <?php endif; ?>

    </div>

</div>

    <?php if($name == 'logotipo' && !$form -> getObject() -> isNew()): ?>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_logotipo">
    <div>
        <label>Imagen logotipo</label>
        <div class="content">
                    <?php if(!$form -> getObject() -> isNew()) : ?>
                        <?php echo image_tag('/uploads/'. $form ->getObject() -> getLogotipo(), array('width' => '100')) ?>
                    <?php endif; ?>
        </div>
    </div>
</div>
    <?php endif; ?>

<?php endif; ?>
