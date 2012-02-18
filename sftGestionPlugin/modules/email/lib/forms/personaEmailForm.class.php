<?php

class personaEmailForm extends SftEmailForm
{

    public function configure()
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
        $this->widgetSchema['id_persona'] =  new sfWidgetFormInputHidden();  
        $this->widgetSchema['predeterminado'] = new sfWidgetFormChoice(array(
            'choices' => array('1' => __('Si'), '0' => __('No') ),
            'expanded' => true,
            ));
        $this->validatorSchema['direccion'] = new sfValidatorEmail();
        
        $this->setDefault('predeterminado', false);
        unset($this->widgetSchema['id_organismo']);
    }

}
