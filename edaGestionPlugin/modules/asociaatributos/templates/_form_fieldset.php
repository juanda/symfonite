<fieldset id="sf_fieldset_<?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?>">
  <?php if ('NONE' != $fieldset): ?>
    <h2><?php echo __($fieldset, array(), 'messages') ?></h2>
  <?php endif; ?>
  <?php $campo = 'id_usuario';?>
  <?php foreach ($fields as $name => $field): ?>
    <?php if ($form[$campo]->getValue()!=''){?>
          <?php  echo '<input name="eda_usu_atributos_valores[id_usuario]" value="'.$EdaUsuAtributosValores->getIdUsuario().'" id="eda_usu_atributos_valores_id_usuario" type="hidden">';?>
          <?php if ($name!='id_usuario'){?>
           
                <?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?>
                <?php include_partial('asociaatributos/form_field', array(
                'name'       => $name,
                'attributes' => $field->getConfig('attributes', array()),
                'label'      => $field->getConfig('label'),
                'help'       => $field->getConfig('help'),
                'form'       => $form,
                'field'      => $field,
                'class'      => 'sf_admin_form_row sf_admin_'.strtolower($field->getType()).' sf_admin_form_field_'.$name,
                )) ?>
           <?php }?>
        <?php }else{ ?>     
            <?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?>
            <?php include_partial('asociaatributos/form_field', array(
              'name'       => $name,
              'attributes' => $field->getConfig('attributes', array()),
              'label'      => $field->getConfig('label'),
              'help'       => $field->getConfig('help'),
              'form'       => $form,
              'field'      => $field,
              'class'      => 'sf_admin_form_row sf_admin_'.strtolower($field->getType()).' sf_admin_form_field_'.$name,
                )) ?>
       <?php }?> 
  <?php endforeach; ?>
</fieldset>
