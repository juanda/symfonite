<h2>Login externo</h2>

<?php if ($auth): ?>
<h3>Estos son los atributos (hay que hacer algo con ellos)</h3>

<table>
    <th>Atributo</th>
    <th>Valores</th>
<?php foreach ($papi_attributes as $nombre => $atributos): ?>
    <tr>
    <td><?php echo $nombre ?></td>
    <td>
        <ul>
            <?php if($atributos instanceof  sfOutputEscaperArrayDecorator) : ?>
        <?php foreach ($atributos as $atributo): ?>
            <li><?php echo $atributo ?></li>
            <?php endforeach;?>
            <?php else : ?>
            <li><?php echo $atributos ?></li>
            <?php endif; ?>
        </ul>
    </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else : ?>

<h2>Autentificación incorrecta</h2>

<?php endif; ?>



