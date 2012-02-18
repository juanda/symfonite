<?php

class personaTelefonoForm extends SftTelefonoForm
{

    public function configure()
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
        $this->widgetSchema['id_persona'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['updated_at'] = new sfWidgetFormInputHidden();
        unset($this->widgetSchema['id_organismo']);
    }

}
