<?php

class usuarioAtributoValorFormFilter extends SftUsuAtributoValorFormFilter
{
  public function configure()
  {
      $this->widgetSchema['id_usuario'] = new sfWidgetFormInputHidden();      
  }
}
