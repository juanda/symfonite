<td>
  <ul class="sf_admin_td_actions">
    <?php echo $helper->linkToEdit($uo, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php echo $helper->linkToDelete($uo, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
    <li class="sf_admin_action_asociaperfiles">
      <?php echo link_to(__('Perfiles', array(), 'messages'), 'sft_uo_object', array('action'=> 'ListAsociaperfiles', 'id'=>$uo->getId())) ?>
        <?php if($uo -> dameNumeroPerfiles() > 0) : ?>
        (<?php echo $uo -> dameNumeroPerfiles() ?>)
        <?php endif; ?>
    </li>
    <li class="sf_admin_action_asociaperiodos">
      <?php echo link_to(__('Periodos', array(), 'messages'), 'sft_uo_object', array('action'=> 'ListAsociaperiodos', 'id'=>$uo->getId())) ?>
        <?php if($uo -> dameNumeroPeriodos() > 0) : ?>
        (<?php echo $uo -> dameNumeroPeriodos() ?>)
        <?php endif; ?>
    </li>
  </ul>
</td>
