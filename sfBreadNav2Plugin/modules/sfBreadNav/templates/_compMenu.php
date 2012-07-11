<?php use_themes_javascript('jquery/js/jquery-1.6.2.min.js') ?>
<?php use_javascript('../sfBreadNav2Plugin/js/menu.js')?>
<?php use_stylesheet('../sfBreadNav2Plugin/css/menu.css') ?>

<?php //si hay menu, se pinta?>
<?php if(!empty($arrayMenu)):?>
    <div id="nav">
        <ul>
            <?php $nivel = 0 ?>

                <?php foreach ($arrayMenu as $opcionMenu): ?>
                    <?php if ($opcionMenu->getNivel() == $nivel): ?>
                        <?php if ($nivel != 0): ?>
                        </li>
                        <?php endif; ?>
                        <li>
                        <?php echo link_to($opcionMenu->getNombre(), $opcionMenu->getRuta(), array()) ?>
                    <?php elseif ($opcionMenu->getNivel() > $nivel): ?>
                        <?php $nivel++; ?>
                        <ul class="submenu">
                        <li>
                        <?php echo link_to($opcionMenu->getNombre(), $opcionMenu->getRuta(), array()) ?>
                    <?php else: ?>
                        <?php while ($opcionMenu->getNivel() < $nivel): ?>
                        </ul>
                        <?php $nivel--; ?>
                        <?php endwhile; ?>
                        <?php if ($nivel != 0)  ?>
                        </li>
                        <li>
                        <?php echo link_to($opcionMenu->getNombre(), $opcionMenu->getRuta(), array()) ?>
                    <?php endif; ?>
                <?php endforeach; ?>

        </ul>
    </div>
<?php endif; ?>