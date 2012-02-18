<?php

/**
 * SftCredencial form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftCredencialForm extends BaseSftCredencialForm
{

    public function configure()
    {
        $this->validatorSchema->setPostValidator(
                new sfValidatorAnd(array(
                    new sfValidatorPropelUnique(array('model' => 'SftCredencial', 'column' => array('nombre'))),
                ))
        );
    }

}
