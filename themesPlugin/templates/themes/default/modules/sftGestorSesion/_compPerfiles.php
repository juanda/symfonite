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
<?php use_helper('jQuery') ?>
<?php use_javascript('../sfJqueryReloadedPlugin/js/plugins/jquery-ui-1.7.3.custom.min.js') ?>
<?php use_javascript('../sfJqueryReloadedPlugin/js/plugins/ui.core.min.js') ?>
<?php use_javascript('../sfJqueryReloadedPlugin/js/plugins/ui.accordion.min.js') ?>
<?php use_stylesheet('../sfJqueryReloadedPlugin/css/ui-lightness/jquery-ui-1.7.3.custom.css') ?>
<?php use_helper('I18N') ?>

<?php
function porDefecto($conf, $confPersonal)
{
//    echo '<pre>';
//    print_r($conf);
//    print_r($confPersonal);
//    echo '</pre>';
    if($conf == $confPersonal)
       return 'checked="true"';
       
    else
        return '';
    
}

function porDefectoRow($conf, $confPersonal)
{
    if($conf == $confPersonal)
        return 'class="row_por_defecto"';
    else
        return '';
}
?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#periodos").accordion();
    });
</script>

    <?php if(count($tInfoPerfiles)>0):?>
    <div id="sf_admin_content">
    <div id="sf_admin_list">
    <table id="tabla_cambiar_perfil">
        <tr>
            <th><?php echo __('Unidad Organizativa'); ?></th>
            <th><?php echo __('Periodo'); ?></th>
            <th><?php echo __('Perfil'); ?>/<?php echo __('&Aacute;mbito'); ?></th>
            <th><?php echo __('Por defecto'); ?></th>
        </tr>
        <?php foreach ($tInfoPerfiles as $ea): ?>
        <tr>
            <td><?php echo $ea['nombre_uo'] ?></td>
            <td><?php echo $ea['descripcion_ea'] ?></td>
            <td colspan="2">
                <table style="margin:0; width:100%;">
                <?php foreach ($ea['perfiles'] as $perfil): ?><?php //Para cada perfil ?>
                    <?php foreach ($perfil['ambitos'] as $ambito): ?><?php //Para cada uno de sus ambitos ?>
                        <tr <?php echo porDefectoRow(array($perfil['id_perfil'], $ambito['id'], $ea['id_ea']), $confPersonal -> getRaw('conf') ) ?>>
                        <?php if($ambito['nombre'] == 'no_ambitos'): ?>
                            <td>
                            <a href="<?php echo url_for('sftGestorSesion/cambioDePerfil?eIdPerfil='.$perfil['id_perfil'].'&eIdEa='.$ea['id_ea']) ?>"><?php echo $perfil['nombre_perfil'] ?></a>
                            </td>
                            <td>
                            <input name="perfil" onclick="jQuery.ajax({ url: '<?php echo url_for('sftGestorSesion/cambioConfPersonal?eIdPerfil='.$perfil['id_perfil'].'&eIdEa='.$ea['id_ea']) ?>' });" <?php echo porDefecto(array($perfil['id_perfil'], $ambito['id'], $ea['id_ea']), $confPersonal -> getRaw('conf') )?> type="radio" />
                                <?php //echo link_to('entrar','sftGestorSesion/cambioDePerfil?eIdPerfil='.$perfil['id_perfil'].'&eIdEa='.$ea['id_ea']) ?>
                            </td>
                        <?php elseif($ambito['nombre'] == 'porasociar'): ?>
                            <td> el perfil no tiene ámbitos asociados </td>
                        <?php else: ?>
                            <td>
                                <?php echo $perfil['nombre_perfil']?>/<a href="<?php echo url_for('sftGestorSesion/cambioDePerfil?eIdPerfil='.$perfil['id_perfil'].'&eIdAmbito='.$ambito['id'].'&eIdEa='.$ea['id_ea']) ?>"><?php echo $ambito['nombre'] ?></a>
                            </td>
                            <td>
                                <input  onclick="jQuery.ajax({ url: '<?php echo url_for('sftGestorSesion/cambioConfPersonal?eIdPerfil='.$perfil['id_perfil'].'&eIdAmbito='.$ambito['id'].'&eIdEa='.$ea['id_ea']) ?>' });"  name="perfil" <?php echo porDefecto(array($perfil['id_perfil'], $ambito['id'], $ea['id_ea']), $confPersonal -> getRaw('conf') ) ?> type="radio" />
                            </td>
                            <?php //echo link_to($ambito['nombre'],'sftGestorSesion/cambioDePerfil?eIdPerfil='.$perfil['id_perfil'].'&eIdAmbito='.$ambito['id'].'&eIdEa='.$ea['id_ea']) ?>
                        <?php endif; ?>

                        </tr>
                    <?php endforeach;?>
                <?php endforeach;?>
                </table>
            </td>

        </tr>
        <?php endforeach;?>
    </table>
    <?php else:?>
        <b><?php echo __('No tiene asociado ningún perfil en esta aplicaci&oacute;n');?></b>
    <?php endif; ?>
       </div>
    </div>