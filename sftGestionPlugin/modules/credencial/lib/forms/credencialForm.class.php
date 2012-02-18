<?php

 
class credencialForm extends SftCredencialForm
{

    public function configure()
    {
        $this->widgetSchema['id_aplicacion'] =  new sfWidgetFormInputHidden();
        $this->widgetSchema['descripcion'] =  new sfWidgetFormTextarea();
        
        unset($this->widgetSchema['sft_perfil_credencial_list']);
        unset($this->validatorSchema['sft_perfil_credencial_list']);
        
    }

}
