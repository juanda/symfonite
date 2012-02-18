<?php

class sftPAPI_PoA_AdminForm extends sfForm
{

    public function configure()
    {                
        $this->setWidgets(array(
            'redirecturl' => new sfWidgetFormInputText(),
            'pubkey' => new sfWidgetFormTextarea(),
            
        ));
        $this->setValidators(array(
            'redirecturl' => new sfValidatorString(),
            'pubkey' => new sfValidatorString(),            
        ));      
        
        $this->widgetSchema->setNameFormat('papipoa[%s]');
    }

}
