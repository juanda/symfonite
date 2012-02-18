<?php

class personaDireccionForm extends SftDireccionForm
{

    public function configure()
    {        
        $this->widgetSchema['id_persona'] =  new sfWidgetFormInputHidden();                     
        unset($this->widgetSchema['id_organismo']);
    }

}
