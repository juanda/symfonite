<td>                
    <ul class="sf_admin_td_actions">
        <?php if (SftFidAtributoPerfilPeer::retrieveByPK($sf_user->getAttribute('id_atributo',null,'mod_asociaperfiles'), $SftPerfil->getId()) instanceof SftFidAtributoPerfil): ?>
            <li class="sf_admin_action_delete">
                <?php echo link_to(__('Quitar', array(), 'messages'), 'fid_asociaperfiles/ListQuitar?id=' . $SftPerfil->getId(), array()) ?>
            </li>
        <?php else: ?>
            <li class="sf_admin_action_new">
                <?php echo link_to(__('Poner', array(), 'messages'), 'fid_asociaperfiles/ListPoner?id=' . $SftPerfil->getId(), array()) ?>
            </li>
        <?php endif; ?>    
    </ul>
</td>
