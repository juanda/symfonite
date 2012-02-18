<?php

class TelefonoIdUsuarioHiddenFormFilter extends SftTelefonoFormFilter
{
  public function configure()
  {
      $this->widgetSchema['id_usuario'] = new sfWidgetFormInputHidden();   
      unset($this->widgetSchema['created_at']);
      unset($this->widgetSchema['updated_at']);
  }
}
