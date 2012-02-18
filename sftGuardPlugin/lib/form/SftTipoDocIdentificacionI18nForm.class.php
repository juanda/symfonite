<?php

/**
 * SftTipoDocIdentificacionI18n form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftTipoDocIdentificacionI18nForm extends BaseSftTipoDocIdentificacionI18nForm
{

    public function configure()
    {
        $this->validatorSchema['id_idioma'] = new sfValidatorPropelChoice(array(
                    'model' => 'SftCultura',
                    'column' => 'nombre',
                    'required' => false));
    }

}
