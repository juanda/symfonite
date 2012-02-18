<?php

class sftSAML_editConfForm extends sfForm
{

    public function configure()
    {                
        $this->setWidgets(array(            
            'tempdir' => new sfWidgetFormInput(),
            'auth.adminpassword'=> new sfWidgetFormInput(),
            'secretsalt' => sfWidgetFormInput(),
            'technicalcontact_name' => sfWidgetFormInput(),
            'technicalcontact_email' => sfWidgetFormInput(),
            'timezone' => sfWidgetFormInput(),
            'session.duration' => sfWidgetFormInput(),
            'session.requestcache' => sfWidgetFormInput(),
            
            
        ));
        $this->setValidators(array(
            'contentfile' => new sfValidatorString(),                       
        ));      
        
        $this->widgetSchema->setNameFormat('contentfile[%s]');
    }

}
