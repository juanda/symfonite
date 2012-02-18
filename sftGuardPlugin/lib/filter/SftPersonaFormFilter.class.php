<?php

/**
 * SftPersona filter form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
class SftPersonaFormFilter extends BaseSftPersonaFormFilter
{

    public function configure()
    {
        unset($this->widgetSchema['sexo']);
    }

}
