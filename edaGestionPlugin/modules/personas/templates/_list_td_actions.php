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
<?php
$usuario = $EdaPersonas->dameEdaUsuarios(ESC_RAW);
if(is_object($usuario))
    $usuario = $usuario -> getRawValue();
else
    $usuario = null;
?>
<td>
    <ul class="sf_admin_td_actions">
<?php if ($sf_user->hasCredential('EDAGESTIONPLUGIN_administracion')) : ?>
        <?php echo $helper->linkToEdit($EdaPersonas, array('params' => array(), 'class_suffix' => 'edit', 'label' => 'Edit',)) ?>
        <?php echo $helper->linkToDelete($EdaPersonas, array('params' => array(), 'confirm' => 'Are you sure?', 'class_suffix' => 'delete', 'label' => 'Delete',)) ?>
        <?php endif; ?>
        <li class="sf_admin_action_asociaperfiles">
<?php if ($usuario instanceof EdaUsuarios) : ?>
            <?php echo link_to(__('Perfiles', array(), 'messages'), 'personas/ListAsociaPerfiles?id=' . $usuario->getId(), array()) ?>
            <?php endif; ?>
            <?php
            if ($sf_user->hasCredential('EDAGESTIONPLUGIN_administracion'))
            {
                $id_uo = null;
            } else
            {
                $id_uo = $sf_user->getAttribute('idUnidadOrganizativa', null, 'EDAE3User');
            }
            ?>
            <?php if ($EdaPersonas->numeroPerfiles($id_uo) > 0) : ?>
                (<?php echo $EdaPersonas->numeroPerfiles($id_uo) ?>)
<?php endif; ?>

            </li>
            <li class="sf_admin_td_action_cambiapassword">
<?php if ($usuario instanceof EdaUsuarios) : ?>
            <?php echo link_to(__('Password', array(), 'messages'), 'personas/ListPassword?id=' . $usuario->getId(), array()) ?>
            <?php endif; ?>

                </li>

                <li class="sf_admin_td_action_atributos">
<?php if ($usuario instanceof EdaUsuarios) : ?>
            <?php echo link_to(__('Attributos', array(), 'messages'), 'personas/ListAtributos?id=' . $usuario->getId(), array()) ?>
            <?php endif; ?>

        </li>
    </ul>
</td>
