<a href="<?php url_for('@homepage') ?>">

    <?php
    echo image_tag(
            'native/images/logo.png',
            array('class' => 'logo',
                'title' => sfConfig::get('titulo'),
                'alt' => sfConfig::get('titulo')
    ))
    ?>
</a>