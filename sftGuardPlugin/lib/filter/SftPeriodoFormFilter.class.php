<?php

/**
 * SftPeriodo filter form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
class SftPeriodoFormFilter extends BaseSftPeriodoFormFilter
{

    public function configure()
    {
        $this->widgetSchema['estado'] = new sfWidgetFormChoice(array(
                    'choices' => array('cualquiera' => 'cualquiera',  'ACTIVO' => 'ACTIVO', 'INACTIVO' => 'INACTIVO'),
                ));
    }

}
