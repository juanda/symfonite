<td>                
    <ul class="sf_admin_td_actions">
        <?php if (SftFidAtributoAmbitoPeer::retrieveByPK($sf_user->getAttribute('id_atributo',null,'mod_asociaambitos'), $SftAmbito->getId()) instanceof SftFidAtributoAmbito): ?>
            <li class="sf_admin_action_delete">
                <?php echo link_to(__('Quitar', array(), 'messages'), 'fid_asociaambitos/ListQuitar?id=' . $SftAmbito->getId(), array()) ?>
            </li>
        <?php else: ?>
            <li class="sf_admin_action_new">
                <?php echo link_to(__('Poner', array(), 'messages'), 'fid_asociaambitos/ListPoner?id=' . $SftAmbito->getId(), array()) ?>
            </li>
        <?php endif; ?>    
    </ul>
</td>
