<?php

/**
 * SftTipoOrganismoI18n form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftTipoOrganismoI18nForm extends BaseSftTipoOrganismoI18nForm
{

    public function configure()
    {
        $this->validatorSchema['id_idioma'] = new sfValidatorPropelChoice(array(
                    'model' => 'SftCultura',
                    'column' => 'nombre',
                    'required' => true));
    }

}
