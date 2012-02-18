<?php

class EmailIdUsuarioHiddenFormFilter extends SftEmailFormFilter
{
  public function configure()
  {
      $this->widgetSchema['id_usuario'] = new sfWidgetFormInputHidden();   
      unset($this->widgetSchema['predeterminado']);
  }
}
