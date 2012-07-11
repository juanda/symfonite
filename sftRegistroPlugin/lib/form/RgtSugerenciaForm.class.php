<?php

/**
 * RgtSugerencia form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class RgtSugerenciaForm extends BaseRgtSugerenciaForm
{
  public function configure()
  {
        $this->validatorSchema['sugerencia'] = new sfValidatorString(array('required' => true, 'min_length'=>5));
  }
}
