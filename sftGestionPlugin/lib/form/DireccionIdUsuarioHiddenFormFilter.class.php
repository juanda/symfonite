<?php

class DireccionIdUsuarioHiddenFormFilter extends SftDireccionFormFilter
{
  public function configure()
  {
      $this->widgetSchema['id_usuario'] = new sfWidgetFormInputHidden();      
  }
}
