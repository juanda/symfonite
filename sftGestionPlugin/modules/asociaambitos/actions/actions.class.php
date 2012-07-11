<?php
/*
* Copyright 2010 Instituto de Tecnologías Educativas - Ministerio de Educación de España
*
* Licencia con arreglo a la EUPL, Versión 1.1 exclusivamente
* (la «Licencia»);
* Solo podrá usarse esta obra si se respeta la Licencia.
* Puede obtenerse una copia de la Licencia en:
*
* http://ec.europa.eu/idabc/eupl5
* 
* y también en:

* http://ec.europa.eu/idabc/en/document/7774.html
*
* Salvo cuando lo exija la legislación aplicable o se acuerde
* por escrito, el programa distribuido con arreglo a la
* Licencia se distribuye «TAL CUAL»,
* SIN GARANTÍAS NI CONDICIONES DE NINGÚN TIPO, ni expresas
* ni implícitas.
* Véase la Licencia en el idioma concreto que rige
* los permisos y limitaciones que establece la Licencia.
*/
?>
<?php

require_once dirname(__FILE__).'/../lib/asociaambitosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/asociaambitosGeneratorHelper.class.php';

/**
 * asociaambitos actions.
 *
 * @package    GestionEDAE3
 * @subpackage asociaambitos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class asociaambitosActions extends autoAsociaambitosActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $this -> forward404Unless($request -> hasParameter('id_usuario') || $this -> getUser() -> hasAttribute('id_usuario', 'mod_asociaambitos'));
        $this -> forward404Unless($request -> hasParameter('id_perfil') || $this -> getUser() -> hasAttribute('id_perfil', 'mod_asociaambitos'));
        if($request -> hasParameter('id_usuario'))
        {
            $this -> getUser() -> setAttribute('id_usuario', $request -> getParameter('id_usuario'), 'mod_asociaambitos');
        }
        if($request -> hasParameter('id_perfil'))
        {
            $this -> getUser() -> setAttribute('id_perfil', $request -> getParameter('id_perfil'), 'mod_asociaambitos');
        }
        $this -> usuario = SftUsuarioPeer::retrieveByPK($this -> getUser() -> getAttribute('id_usuario', null, 'mod_asociaambitos'));
        $this -> perfil  = SftPerfilPeer::retrieveByPK($this -> getUser() -> getAttribute('id_perfil', null, 'mod_asociaambitos'));

        $c = new Criteria();
        $c -> add(SftAccesoPeer::ID_PERFIL, $this -> perfil -> getId());
        $c -> add(SftAccesoPeer::ID_USUARIO, $this -> usuario -> getId());

        $this -> acceso = SftAccesoPeer::doSelectOne($c);
        $this -> getUser() -> setAttribute('id_acceso', $this -> acceso -> getId(), 'mod_asociaambitos');


        $this -> forward404Unless($this -> usuario instanceof SftUsuario);
        // sorting
        if ($request->getParameter('sort') && $this->isValidSortColumn($request->getParameter('sort')))
        {
            $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
        }

        // pager
        if ($request->getParameter('page'))
        {
            $this->setPage($request->getParameter('page'));
        }

        $this->pager = $this->getPager();
        $this->sort = $this->getSort();

        $this -> setLayout('ventanaNueva');

    }

    public function executeListPoner(sfWebRequest $request)
    {
        $this  -> forward404Unless($this -> getUser() -> hasAttribute('id_acceso', 'mod_asociaambitos'));
        $this  -> forward404Unless($request -> hasParameter('id'));

        $acceso = SftAccesoPeer::retrieveByPK($this -> getUser() -> getAttribute('id_acceso', null, 'mod_asociaambitos'));
        $this -> forward404Unless($acceso instanceof SftAcceso);

        $ambito = SftAmbitoPeer::retrieveByPK($request -> getParameter('id'));

        $acceso -> ponAmbito($ambito);

        $this -> redirect('@sft_ambito_asociaambitos');

    }

    public function executeListQuitar(sfWebRequest $request)
    {
        $this  -> forward404Unless($this -> getUser() -> hasAttribute('id_acceso', 'mod_asociaambitos'));
        $this  -> forward404Unless($request -> hasParameter('id'));

        $acceso = SftAccesoPeer::retrieveByPK($this -> getUser() -> getAttribute('id_acceso', null, 'mod_asociaambitos'));
        $this -> forward404Unless($acceso instanceof SftAcceso);

        $ambito = SftAmbitoPeer::retrieveByPK($request -> getParameter('id'));

        $acceso -> quitaAmbito($ambito);

        $this -> redirect('@sft_ambito_asociaambitos');
    }

    protected function buildCriteria()
    {
        if (null === $this->filters)
        {
            $this->filters = $this->configuration->getFilterForm($this->getFilters());
        }

        $perfil = SftPerfilPeer::retrieveByPK($this -> getUser() -> getAttribute('id_perfil', null, 'mod_asociaambitos'));

        $criteria = $this->filters->buildCriteria($this->getFilters());

        $criteria -> add(SftPerfilPeer::ID, $perfil -> getId());
        $criteria -> add(SftPeriodoPeer::ID_UO, $perfil -> getIdUo());
        $criteria -> addJoin(SftPeriodoPeer::ID, SftAmbitoPeer::ID_PERIODO);
        $criteria -> addJoin(SftAmbitoPeer::ID_AMBITOTIPO, SftPerfilPeer::ID_AMBITOTIPO);

        $this->addSortCriteria($criteria);


        $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_criteria'), $criteria);
        $criteria = $event->getReturnValue();

        return $criteria;
    }
}
