<?php

/**
 * SftUsuario form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftUsuarioForm extends BaseSftUsuarioForm
{

    public function configure()
    {
        $this->widgetSchema['id_culturapref'] = new sfWidgetFormPropelChoice(array('model' => 'SftCultura', 'add_empty' => true));
    }

    public function validarSoloCultura()
    {
        $validatorLang = $this->getValidator('id_culturapref');
        $this->setValidatorSchema(new sfValidatorSchema());
        $this->setValidator('id_culturapref', $validatorLang);
    }

}
