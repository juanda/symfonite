<?php

/**
 * SftTelefono form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftTelefonoForm extends BaseSftTelefonoForm
{

    public function configure()
    {
        $this->widgetSchema['id_persona'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['id_organismo'] = new sfWidgetFormInputHidden();

        unset($this->widgetSchema['created_at']);
        unset($this->widgetSchema['updated_at']);
        unset($this->validatorSchema['created_at']);
        unset($this->validatorSchema['updated_at']);

        $this->setDefault('id_persona', $this->getOption('id_persona'));
        $this->setDefault('id_organismo', $this->getOption('id_organismo'));
    }

}
