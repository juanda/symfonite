<?php

/**
 * SftAmbitoTipo form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftAmbitoTipoForm extends BaseSftAmbitoTipoForm
{
  public function configure()
  {
      $this->widgetSchema['descripcion'] = new sfWidgetFormTextarea();
  }
}
