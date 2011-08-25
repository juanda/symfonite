<td class="sf_admin_text sf_admin_list_td_nombre">
    <?php echo $uo->getNombre() ?>
    <?php if ($uo->noTienePeriodos()): ?>
    <font color="red"> (<?php echo __('sin periodos') ?>)</font>
    <?php endif; ?>
    <?php if ($uo->noTienePerfiles()): ?>
    <font color="red"> (<?php echo __('sin perfiles') ?>)</font>
    <?php endif; ?>
</td>
<td class="sf_admin_text sf_admin_list_td_codigo">
    <?php echo $uo->getCodigo() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_observaciones">
    <?php echo $uo->getObservaciones() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_marca">
    <?php echo $uo->getMarca() ?>
</td>
