<?php

class personaTelefonoFormFilter extends SftTelefonoFormFilter
{
  public function configure()
  {
      $this->widgetSchema['id_persona'] = new sfWidgetFormInputHidden();      
      unset($this->widgetSchema['id_organismo']);
      unset($this->widgetSchema['created_at']);
      unset($this->widgetSchema['updated_at']);
  }
}
