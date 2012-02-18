<?php

/**
 * SftPeriodo form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftPeriodoForm extends BaseSftPeriodoForm
{

    public function configure()
    {
        $this->widgetSchema['estado'] = new sfWidgetFormChoice(array('choices' => array('ACTIVO' => 'ACTIVO', 'INACTIVO' => 'INACTIVO')));
        $this->getWidget('fechainicio')->setOption('format', '%day% - %month% - %year%');
        $this->getWidget('fechafin')->setOption('format', '%day% - %month% - %year%');
    }

}
