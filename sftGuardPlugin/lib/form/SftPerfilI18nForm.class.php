<?php

/**
 * SftPerfilI18n form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftPerfilI18nForm extends BaseSftPerfilI18nForm
{

    public function configure()
    {
        $this->validatorSchema['id_cultura'] = new sfValidatorPropelChoice(array(
                    'model' => 'SftCultura',
                    'column' => 'nombre',
                    'required' => true));
    }

}
