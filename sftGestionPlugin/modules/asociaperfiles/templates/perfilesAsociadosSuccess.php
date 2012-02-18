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
<?php use_helper('I18N', 'Date') ?>
<?php include_partial('asociaperfiles/assets') ?>
<?php use_helper('jQuery') ?>
<?php use_themes_javascript('jquery/js/jquery-1.6.2.min.js') ?>
<?php use_themes_javascript('colorbox/js/jquery.colorbox.js') ?>
<?php use_themes_stylesheet('colorbox/css/colorbox.css') ?>


<script>
    $(document).ready(function(){

        $(".asociaperfiles").colorbox({iframe:true, width:800, height:500,
            onClosed:function(){ location.reload(true); }
        });
        $(".asociaambitos").colorbox({iframe:true, width:800, height:500,
            onClosed:function(){ location.reload(true); }
        });
    });
</script>

<div id="sf_admin_container">
    <h1><?php echo __('Gestión de Perfiles del usuario', array(), 'messages') ?>: <?php echo $usuario  ?></h1>

    <?php include_partial('asociaperfiles/flashes') ?>


    <div id="sf_admin_content">

        <h2>Perfiles Asociados</h2>        

        <ul class="sf_admin_td_actions">
            <li class="sf_admin_action_list">
                <?php echo link_to(__('volver al listado de usuarios'), $linkUsuarios) ?>
            </li>

            <li class="sf_admin_action_asociaperfiles">
                <?php echo link_to(__('asociar/desasociar perfiles'), 'asociaperfiles/index', array('class' =>'asociaperfiles')) ?>
            </li>
        </ul>
        <br/>
        <div class="sf_admin_list">
            <table>
                <tr>
                    <th><?php echo __("nombre")?></th>
                    <th><?php echo __("descripcion")?></th>
                    <th><?php echo __("uo")?></th>
                    <th><?php  echo __('Ámbitos Asociados') ?></th>
                </tr>
                <?php foreach ($perfiles as $perfil): ?>
                <tr>
                    <td><?php echo $perfil -> getNombre() ?> </td>
                    <td><?php echo $perfil -> getDescripcion() ?></td>
                    <td><?php echo $perfil -> getSftUo() -> getNombre() ?></td>
                    <td>
                            <?php if(!is_null($perfil -> getIdAmbitoTipo())) : ?>

                        <table border="0">

                                    <?php foreach($usuario -> dameAmbitos($perfil) as $ambito): ?>
                            <tr>
                                <td>
                                                <?php echo $ambito -> getNombre() ?> - <?php echo $ambito -> getSftPeriodo() ?>(<?php echo $ambito -> getEstado() ?>)
                                </td>
                                <td>
                                    <ul class="sf_admin_td_actions">
                                        <li class="sf_admin_action_delete">
                                                        <?php echo link_to(__('Quitar'), 'asociaperfiles/quitarAmbito?id_usuario='.$usuario -> getId().'&id_ambito='.$ambito -> getId()) ?>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                                    <?php endforeach; ?>
                            <tr>
                                <td colspan="2">

                                    <ul class="sf_admin_td_actions">
                                        <li class="sf_admin_action_new">
                                                    <?php echo link_to(__('Añadir ámbito'), 'asociaambitos/index?id_usuario='.$usuario -> getId().'&id_perfil='.$perfil -> getId(), array('class' => 'asociaambitos')) ?>
                                        </li>
                                    </ul>

                                </td>
                            </tr>

                        </table>
                            <?php endif; ?>
                    </td>


                </tr>
                <?php endforeach; ?>
                <?php if(count($perfiles) == 0): ?>
                <tr>
                    <td colspan="3"><?php echo __("Este usuario no tiene perfiles asociados para los términos de la búsqueda")?></td>
                </tr>
                <?php endif; ?>

            </table>
        </div>

       
    </div>

</div>
