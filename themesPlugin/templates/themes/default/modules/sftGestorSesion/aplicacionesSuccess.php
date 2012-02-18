<?php
/*
 * Copyright 2010 Instituto de Tecnologías Educativas - Ministerio de Educación de España
 *
 * Licencia con arreglo a la EUPL, Versión 1.1 exclusivamente
 * (la «Licencia»);
 * Solo podrá usarse esta obra si se respeta la Licencia.
 * Puede obtenerse una copia de la Licencia en:
 *
 * http://ec.europa.eu/idabc/eupl5
 * 
 * y también en:

 * http://ec.europa.eu/idabc/en/document/7774.html
 *
 * Salvo cuando lo exija la legislación aplicable o se acuerde
 * por escrito, el programa distribuido con arreglo a la
 * Licencia se distribuye «TAL CUAL»,
 * SIN GARANTÍAS NI CONDICIONES DE NINGÚN TIPO, ni expresas
 * ni implícitas.
 * Véase la Licencia en el idioma concreto que rige
 * los permisos y limitaciones que establece la Licencia.
 */
?>
<script>
    function ventanaNueva(aUrl,aNombre,aParametros,aTxtBarra)
    {

        // aParametros = aParametros + " dependent = 'yes'"; // hacemos que haya dependencia de ventanas

        aNombre = window.open(aUrl,aNombre,aParametros);

        aNombre.focus();

        window.status=aTxtBarra;
    } ;

</script>

<h1>Aplicaciones disponibles</h1>

<div id="sf_admin_container">
    <div class="hint">Pulsa en el icono para lanzar la aplicación</div>

    <div id="contenedor_aplicaciones">

        <?php foreach ($aplicaciones as $ap): ?>
            <?php $descripcion = ($ap->getRaw('descripcion') == '') ? 'No hay descripción disponible' : $ap->getRaw('descripcion'); ?>
            <?php $rutaImagen = ($ap->getRaw('logotipo') == '') ? image_themes_tag('native/images/aplicacion.png', array('title' => $descripcion, 'width' => '50', 'heigth' => '50')) : image_tag('/uploads/' . $ap->getRaw('logotipo'), array('title' => $descripcion, 'width' => '50', 'heigth' => '50')) ?>


            <div class="picture left" style="width:52px; ">
                <?php if ($ap->getRaw('clave') != sfConfig::get('app_clave')): ?>

                    <a href="<?php echo url_for('inicio/abreAplicacion?id_aplicacion=' . $ap['id']) ?>">
                        <?php echo $rutaImagen ?></a>

                    <br /><?php echo $ap->getRaw('nombre') ?>
                <?php else: ?>
                    <?php echo $rutaImagen ?>
                    <br /><?php echo '<b>' . $ap->getRaw('nombre') . '</b>' ?>
                <?php endif ?>
            </div>

        <?php endforeach; ?>

    </div>

</div>