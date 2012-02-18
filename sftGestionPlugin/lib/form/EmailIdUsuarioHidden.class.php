<?php

class EmailIdUsuarioHiddenForm extends SftEmailForm
{

    public function configure()
    {     
        sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');  
        $this->widgetSchema['predeterminado'] = new sfWidgetFormChoice(array(
            'choices' => array('1' => __('Si'), '0' => __('No') ),
            'expanded' => true,
            ));
        $this->validatorSchema['direccion'] = new sfValidatorEmail();
        
        $this->setDefault('predeterminado', false);
        
        $this->widgetSchema['id_usuario'] =  new sfWidgetFormInputHidden();  
        
        
        
        
    }

}
