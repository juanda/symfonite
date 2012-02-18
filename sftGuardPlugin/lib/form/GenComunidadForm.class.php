<?php

/**
 * GenComunidad form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class GenComunidadForm extends BaseGenComunidadForm
{
  public function configure()
  {
      EmbedI18n::aniadeTraducciones($this);
  }
}
