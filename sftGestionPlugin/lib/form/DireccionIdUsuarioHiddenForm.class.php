<?php

class DireccionIdUsuarioHiddenForm extends SftDireccionForm
{

    public function configure()
    {        
        $this->widgetSchema['id_usuario'] =  new sfWidgetFormInputHidden();                     
    }

}