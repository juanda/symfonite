<?php

/**
 * SftFidAtributo form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftFidAtributoForm extends BaseSftFidAtributoForm
{

    public function configure()
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
        
        $mapas = array(
            'email'     => __('correo electrónico'),
            'username'  => __('nombre de usuario'),
            'nombre'    => __('nombre'),
            'apellido1' => __('apellido1'),
            'apellido2' => __('apellido2')
            );
        
        $this->widgetSchema['mapa'] = new sfWidgetFormChoice(array('choices' => $mapas));
    }

}
