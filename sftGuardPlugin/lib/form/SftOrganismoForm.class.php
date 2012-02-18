<?php

/**
 * SftOrganismo form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftOrganismoForm extends BaseSftOrganismoForm
{
  public function configure()
    {
        $this -> getWidget('created_at') -> setOption('date', array('format' => '%day% - %month% - %year%'));
        $this -> getWidget('updated_at') -> setOption('date', array('format' => '%day% - %month% - %year%'));
    }
}
