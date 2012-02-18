<?php

/**
 * GenProvincia form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class GenProvinciaForm extends BaseGenProvinciaForm
{
  public function configure()
  {
      EmbedI18n::aniadeTraducciones($this);
  }
}
