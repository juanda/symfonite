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
    <br/>
    <div id="sft_aplicaciones_container">
        <?php
        $aplicacion_css = "sft_aplicacion_container_left";
        $atributo_css = "sft_aplicacion_atributos_left";
        $atributo2_css = "sft_aplicacion_atributos_right";
        ?>
        <?php foreach ($aplicaciones as $ap): ?> 
            <?php $descripcion = ($ap->getRaw('descripcion') == '') ? 'No hay descripción disponible' : $ap->getRaw('descripcion'); 
                    $ruta = $ap->getRaw('logotipo');
                    if (!empty($ruta)){
                        echo $ruta;
                    }else{
                        //echo "Default";
                    }
                    ?>
            <?php $rutaImagen = ($ap->getRaw('logotipo') == '') ? image_themes_tag('native/images/aplicacion.png', array('title' => $descripcion, 'width' => '50', 'heigth' => '50')) : image_tag('/uploads/' . $ap->getRaw('logotipo'), array('title' => $descripcion, 'width' => '50', 'heigth' => '50')) ?>
            <center>
                <?php if ($ap->getRaw('clave') != sfConfig::get('app_clave')): ?>
                    <a href="<?php echo url_for('@sftGuardPlugin_abreAplicacion?id_aplicacion=' . $ap['id']) ?>">
                        <div class="<?php echo $aplicacion_css; ?>" >

                            <div class="<?php echo $atributo_css; ?>" style="height:50px;margin-top:2px">
                                <?php echo $rutaImagen ?>
                            </div>
                            <div class="<?php echo $atributo2_css; ?>">
                                <?php
                                echo $ap->getRaw('nombre') . "<br/>";
                                echo $ap->getRaw('descripcion') . "<br/>";
                                echo $ap->getRaw('url');
                                ?>
                            </div>
                        </div>                    
                    </a>
                <?php else: ?>
                    <div class="<?php echo $aplicacion_css; ?>" style=" background-color:#464646;">
                        <div class="<?php echo $atributo_css; ?>" style="height:50px;margin-top:2px">
                            <?php echo $rutaImagen ?>
                        </div>
                        <div class="<?php echo $atributo2_css; ?>">
                            <?php
                            echo "<b>" . $ap->getRaw('nombre') . "<br/>";
                            echo $ap->getRaw('descripcion') . "<br/>";
                            echo $ap->getRaw('url') . "</b>";
                            ?>
                        </div>
                    </div>
                <?php endif ?>
            </center>


            <?php
            if ($aplicacion_css == "sft_aplicacion_container_left") {
                $aplicacion_css = "sft_aplicacion_container_right";
                $atributo_css = "sft_aplicacion_atributos_right";
                $atributo2_css = "sft_aplicacion_atributos_left";
            } else {
                $aplicacion_css = "sft_aplicacion_container_left";
                $atributo_css = "sft_aplicacion_atributos_left";
                $atributo2_css = "sft_aplicacion_atributos_right";
            }
            ?>
        <?php endforeach; ?>
    </div>
</div>