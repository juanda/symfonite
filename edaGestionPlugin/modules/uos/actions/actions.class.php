<?php

require_once dirname(__FILE__).'/../lib/uosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/uosGeneratorHelper.class.php';

/**
 * uos actions.
 *
 * @package    GestionEDAE3
 * @subpackage uos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class uosActions extends autoUosActions
{
    public function executeListAsociaperfiles(sfWebRequest $request)
    {
        $id_uo = $request -> getParameter('id');

        $perfiles_filter = array('id_uo' => $id_uo);
        $this -> getUser() -> setAttribute('perfiles.filters', $perfiles_filter, 'admin_module');

        $this -> redirect('perfiles/index');
    }

    public function executeListAsociaperiodos(sfWebRequest $request)
    {
        $id_uo = $request -> getParameter('id');

        $periodos_filter = array('id_uo' => $id_uo);
        $this -> getUser() -> setAttribute('periodos.filters', $periodos_filter, 'admin_module');

        $this -> redirect('periodos/index');
    }

    public function executeDelete(sfWebRequest $request)
    {
        $uo = EdaUosPeer::retrieveByPK($request -> getParameter('id'));
        if(count($uo -> getEdaPerfiless()) != 0)
        {
            $this -> redirect('edaGestorErrores/mensajeError?mensaje=La Unidad Organizativa tiene perfiles asociados y no se pudede eliminar');
        }
        if(count($uo -> getEdaPeriodoss()) != 0)
        {
            $this -> redirect('edaGestorErrores/mensajeError?mensaje=La Unidad Organizativa tiene periodos asociados y no se pudede eliminar');
        }


        parent::executeDelete($request);
    }
}
