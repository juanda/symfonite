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

        $this -> redirect('@sft_perfil');
    }

    public function executeListAsociaperiodos(sfWebRequest $request)
    {
        $id_uo = $request -> getParameter('id');

        $periodo_filter = array('id_uo' => $id_uo);
        $this -> getUser() -> setAttribute('periodo.filters', $periodo_filter, 'admin_module');

        $this -> redirect('@sft_periodo');
    }

    public function executeDelete(sfWebRequest $request)
    {
        $uo = SftUoPeer::retrieveByPK($request -> getParameter('id'));
        if(count($uo -> getSftPerfils()) != 0)
        {
            $this -> redirect('@sftGuardPlugin_mensajeError?mensaje=La Unidad Organizativa tiene perfiles asociados y no se puede eliminar');
        }else if(count($uo -> getSftPeriodos()) != 0)
        {
            $this -> redirect('@sftGuardPlugin_mensajeError?mensaje=La Unidad Organizativa tiene periodos asociados y no se puede eliminar');
        }else if(!strcmp($request->getParameter('id'), $this->getUser()->getAttribute('idUnidadOrganizativa', null, 'SftUser'))) {
            $this -> redirect('@sftGuardPlugin_mensajeError?mensaje=El usuario actual pertenece a la Unidad Organizativa y no se puede eliminar');
        }


        parent::executeDelete($request);
    }
}
