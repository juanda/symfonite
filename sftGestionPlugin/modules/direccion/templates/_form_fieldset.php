<?php include_javascripts() ?>
<fieldset id="sf_fieldset_<?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?>">
    <?php if ('NONE' != $fieldset): ?>
        <h2><?php echo __($fieldset, array(), 'messages') ?></h2>
    <?php endif; ?>

    <?php foreach ($fields as $name => $field): ?>
        <?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?>
        <?php if (!strcmp($name, 'provincia')): ?>
            <div class="<?php echo 'sf_admin_form_row sf_admin_' . strtolower($field->getType()) . ' sf_admin_form_field_' . $name ?>">
                <div>
                    <label for="provincia">Provincia</label>
                    <div class="content">
                        <div id="sf_list_provincias">
                             <br/>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif (!strcmp($name, 'municipio')): ?>
            <div class="<?php echo 'sf_admin_form_row sf_admin_' . strtolower($field->getType()) . ' sf_admin_form_field_' . $name ?>">
                <div>
                    <label for="localidad">Municipio</label>
                    <div class="content">
                        <div id="sf_list_localidades">
                            <br/>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <?php
            include_partial('direccion/form_field', array(
                'name' => $name,
                'attributes' => $field->getConfig('attributes', array()),
                'label' => $field->getConfig('label'),
                'help' => $field->getConfig('help'),
                'form' => $form,
                'field' => $field,
                'class' => 'sf_admin_form_row sf_admin_' . strtolower($field->getType()) . ' sf_admin_form_field_' . $name,
            ))
            ?>
        <?php endif; ?>
    <?php endforeach; ?>
</fieldset>

<script>
    $('#sft_direccion_pais').change(function(){
        jQuery.ajax({
            type:'POST',
            dataType:'html',
            data:{pais:$('#sft_direccion_pais').val()},
            success:function(data, textStatus){jQuery('#sf_list_provincias').html(data);},
            url: "<?php echo url_for('sftGestionPlugin_ListProvincias') ?>"
        });
        
        jQuery.ajax({
            type:'POST',
            dataType:'html',
            data:{pais:$('#sft_direccion_pais').val()},
            success:function(data, textStatus){jQuery('#sf_list_localidades').html(data);},
            url: "<?php echo url_for('sftGestionPlugin_ListLocalidades') ?>"
        });
    });
</script>
