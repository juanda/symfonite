<?php use_helper('I18N', 'Date') ?>
<?php include_partial('aplicacion/assets') ?>

<div id="sf_admin_container">
    <h1><?php echo __('Listado de Aplicaciones', array(), 'messages') ?></h1>

    <?php include_partial('aplicacion/flashes') ?>

    <?php if (!file_exists(dirname(__FILE__).'/../../../../sftSAMLPlugin/lib/vendor/simplesamlphp-1.8.0-rc1/metadata/.saml_enabled' )) : ?>
        <div class="error">
            <div class="error">
                <?php echo __('El sistema de identificación federada SAML no se ha podido habilitar.
                    Para habilitarlo debes asegurarte que los siguientes archivos tengan permisos de escritura para el servidor web, y volver a iniciar de nuevo la sesión.') ?>
                <ul>
                <li>
                    <?php echo 'chmod -R 777 '.realpath(dirname(__FILE__) . '/../../../../sftSAMLPlugin/lib/vendor/simplesamlphp-1.8.0-rc1/metadata')?>
                </li>
                <li>
                    <?php echo 'chmod -R 777 '.realpath(dirname(__FILE__) . '/../../../../sftSAMLPlugin/lib/vendor/simplesamlphp-1.8.0-rc1/config/config.php') ?>
                </li>               
            </ul>
            </div>
            

        </div>
    <?php endif; ?>

    <div id="sf_admin_header">
        <?php include_partial('aplicacion/list_header', array('pager' => $pager)) ?>
    </div>

    <div id="sf_admin_bar">
        <?php include_partial('aplicacion/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
    </div>

    <div id="sf_admin_content">
        <form action="<?php echo url_for('sft_aplicacion_collection', array('action' => 'batch')) ?>" method="post">
            <?php include_partial('aplicacion/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
            <?php if (sfConfig::get('muestraNota') == true): ?>
                <table>
                    <tr>
                        <?php echo __('Nota') ?>
                    </tr>
                    <tr>
                        <td><?php echo image_themes_tag('native/images/16x16/page_error.png') ?></td>
                        <td> <?php echo __('Los ficheros de las aplicaciones que llevan este icono no se han generado aún.<br/>
                    Puedes copiar el código que se muestra al lado de dichos iconos y ejecutarlo en una CLI para generar la aplicación') ?></td>
                    </tr>
                </table>
            <?php endif; ?>
            <ul class="sf_admin_actions">

                <?php include_partial('aplicacion/list_batch_actions', array('helper' => $helper)) ?>
                <?php include_partial('aplicacion/list_actions', array('helper' => $helper)) ?>
            </ul>
        </form>
    </div>

    <div id="sf_admin_footer">

        <?php include_partial('aplicacion/list_footer', array('pager' => $pager)) ?>
    </div>
</div>
