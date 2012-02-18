<?php

class usuarioAtributoValorForm extends SftUsuAtributoValorForm
{

    public function configure()
    {       
        $this->widgetSchema['id_usuario'] =  new sfWidgetFormInputHidden();          
    }

}
