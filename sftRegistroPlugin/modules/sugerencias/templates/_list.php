<?php foreach ($sugerencias as $i => $sugerencia): ?>
    <?php $user = SftUsuarioPeer::retrieveByPK( $sugerencia->getIdUsuario());?>
    <div class="entrada">
        <p class="rgtAutor"><?php echo (($paginador->getPage()-1)*$maxPager+$i+1).". por " . $user->getAlias() ?></p>
        <p class="rgtSugerencia"><?php echo $sugerencia->getSugerencia(); ?></p>
    </div>
<?php endforeach; ?>
