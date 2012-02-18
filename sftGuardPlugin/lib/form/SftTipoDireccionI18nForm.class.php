<?php

/**
 * SftTipoDireccionI18n form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftTipoDireccionI18nForm extends BaseSftTipoDireccionI18nForm
{

    public function configure()
    {
        $this->validatorSchema['id_idioma'] = new sfValidatorPropelChoice(array(
                    'model' => 'SftCultura',
                    'column' => 'nombre',
                    'required' => true));
    }

}
