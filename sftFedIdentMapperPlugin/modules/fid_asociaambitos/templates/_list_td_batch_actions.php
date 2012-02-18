<td>
    <?php if (SftFidAtributoAmbitoPeer::retrieveByPK($sf_user->getAttribute('id_atributo', null, 'mod_asociaambitos'), $SftAmbito->getId()) instanceof SftFidAtributoAmbito): ?>
        <?php echo image_themes_tag('native/images/16x16/link.png', array('alt' => 'asociada')) ?>
    <?php else: ?>
        <?php echo image_themes_tag('native/images/16x16/link_break.png', array('alt' => 'asociada')) ?>
    <?php endif; ?>
</td>
