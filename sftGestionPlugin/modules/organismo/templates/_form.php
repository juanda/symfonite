<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="sf_admin_form">
    <?php echo form_tag_for($form, '@sft_organismo') ?>
    <?php echo $form->renderHiddenFields(false) ?>

    <?php if ($form->hasGlobalErrors()): ?>
    <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>
    <?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?>
        
    <?php if ($form -> isNew() && in_array($fieldset, array('identificación', 'teléfonos', 'direcciones' ))) continue ?>
    <?php  include_partial('organismo/form_fieldset', array('SftOrganismo' => $SftOrganismo, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?>
    <?php endforeach; ?>

    <?php include_partial('organismo/form_actions', array('SftOrganismo' => $SftOrganismo, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
</form>
</div>
