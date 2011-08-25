<h2>Login externo</h2>
<h3>Estos son los metadatos (hay que hacer algo con ellos)</h3>


<table>
    <th>Atributo</th>
    <th>Valores</th>
<?php foreach ($saml_attributes as $nombre => $atributos): ?>
    <tr>
    <td><?php echo $nombre ?></td>
    <td>
        <ul>
        <?php foreach ($atributos as $atributo): ?>
            <li><?php echo $atributo ?></li>
            <?php            endforeach;?>
        </ul>
    </td>
    </tr>
    <?php endforeach; ?>
</table>


