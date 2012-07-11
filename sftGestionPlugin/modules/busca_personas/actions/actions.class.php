<?php

require_once dirname(__FILE__).'/../lib/busca_personasGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/busca_personasGeneratorHelper.class.php';

/**
 * personas actions.
 *
 * @package    GestionProyectos
 * @subpackage personas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class busca_personasActions extends autobusca_PersonasActions
{
    public function executeIndex(sfWebRequest $request)
    {
        parent::executeIndex($request);

        if($request -> hasParameter('nombreCajaTexto'))
        {
            $this -> getUser() -> setAttribute('nombreCajaTexto', $request -> getParameter('nombreCajaTexto'));
        }
        if($request -> hasParameter('nombreCajaHidden'))
        {
            $this -> getUser() -> setAttribute('nombreCajaHidden', $request -> getParameter('nombreCajaHidden'));
        }

    }
    public function executeListSeleccionar(sfWebRequest $request)
    {
        $persona = SftPersonaPeer::retrieveByPK($request->getParameter('id'));

       
        $this -> idUsuario = $persona->dameSftUsuario()->getId();

        $this -> nombre = $persona ->getNombreCompleto();
       
    }  
}
