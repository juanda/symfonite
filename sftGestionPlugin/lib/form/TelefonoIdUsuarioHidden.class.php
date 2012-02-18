<?php

class TelefonoIdUsuarioHiddenForm extends SftTelefonoForm
{

    public function configure()
    {        
        $this->widgetSchema['id_usuario'] =  new sfWidgetFormInputHidden();  
        $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['updated_at'] = new sfWidgetFormInputHidden();
    }

}
