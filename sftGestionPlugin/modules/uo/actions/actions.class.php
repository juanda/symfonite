<?php

require_once dirname(__FILE__).'/../lib/uoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/uoGeneratorHelper.class.php';

/**
 * uos actions.
 *
 * @package    GestionEDAE3
 * @subpackage uos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class uoActions extends autoUoActions
{
    public function executeListAsociaperfiles(sfWebRequest $request)
    {
        $id_uo = $request -> getParameter('id');

        $perfiles_filter = array('id_uo' => $id_uo);
        $this -> getUser() -> setAttribute('perfil.filters', $perfiles_filter, 'admin_module');

        $this -> redirect('perfil/index');
    }

    public function executeListAsociaperiodos(sfWebRequest $request)
    {
        $id_uo = $request -> getParameter('id');

        $periodo_filter = array('id_uo' => $id_uo);
        $this -> getUser() -> setAttribute('periodo.filters', $periodo_filter, 'admin_module');

        $this -> redirect('periodo/index');
    }

    public function executeDelete(sfWebRequest $request)
    {
        $uo = SftUoPeer::retrieveByPK($request -> getParameter('id'));
        if(count($uo -> getSftPerfils()) != 0)
        {
            $this -> redirect('sftGestorErrores/mensajeError?mensaje=La Unidad Organizativa tiene perfiles asociados y no se pudede eliminar');
        }
        if(count($uo -> getSftPeriodos()) != 0)
        {
            $this -> redirect('sftGestorErrores/mensajeError?mensaje=La Unidad Organizativa tiene periodos asociados y no se pudede eliminar');
        }


        parent::executeDelete($request);
    }
}
