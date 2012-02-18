<?php

class personaEmailFormFilter extends SftEmailFormFilter
{
  public function configure()
  {
      $this->widgetSchema['id_persona'] = new sfWidgetFormInputHidden();
      unset($this->widgetSchema['predeterminado']);
      unset($this->widgetSchema['id_organismo']);
  }
}
