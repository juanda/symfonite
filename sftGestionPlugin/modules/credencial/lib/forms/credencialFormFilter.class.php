<?php

/**
 * SftCredencial filter form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
class credencialFormFilter extends SftCredencialFormFilter
{
  public function configure()
  {
      $this->widgetSchema['id_aplicacion'] = new sfWidgetFormInputHidden();
      //unset($this->widgetSchema['id_aplicacion']);
  }
}
