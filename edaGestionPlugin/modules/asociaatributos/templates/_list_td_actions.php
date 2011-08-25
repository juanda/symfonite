<td>
  <ul class="sf_admin_td_actions">
    <?php echo $helper->linkToEdit($EdaUsuAtributosValores, array(  'params' =>   array('id_usuario' => $id_usuario ),  'class_suffix' => 'edit',  'label' => 'Edit',));?>
    <?php echo $helper->linkToDelete($EdaUsuAtributosValores, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
  </ul>
</td>
