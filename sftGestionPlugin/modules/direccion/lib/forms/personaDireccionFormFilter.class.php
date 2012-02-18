<?php

class personaDireccionFormFilter extends SftDireccionFormFilter
{
  public function configure()
  {
      $this->widgetSchema['id_persona'] = new sfWidgetFormInputHidden();      
      unset($this->widgetSchema['id_organismo']);
  }
}
