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
        $this -> usuario = EdaUsuariosPeer::retrieveByPK($this -> getUser() -> getAttribute('id_usuario', null, 'mod_asociaambitos'));
        $this -> perfil  = EdaPerfilesPeer::retrieveByPK($this -> getUser() -> getAttribute('id_perfil', null, 'mod_asociaambitos'));

        $c = new Criteria();
        $c -> add(EdaAccesosPeer::ID_PERFIL, $this -> perfil -> getId());
        $c -> add(EdaAccesosPeer::ID_USUARIO, $this -> usuario -> getId());

        $this -> acceso = EdaAccesosPeer::doSelectOne($c);
        $this -> getUser() -> setAttribute('id_acceso', $this -> acceso -> getId(), 'mod_asociaambitos');


        $this -> forward404Unless($this -> usuario instanceof EdaUsuarios);
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
        $this  -> forward404Unless($request -> hasParameter('id_ambito'));

        $acceso = EdaAccesosPeer::retrieveByPK($this -> getUser() -> getAttribute('id_acceso', null, 'mod_asociaambitos'));
        $this -> forward404Unless($acceso instanceof EdaAccesos);

        $ambito = EdaAmbitosPeer::retrieveByPK($request -> getParameter('id_ambito'));

        $acceso -> ponAmbito($ambito);

        $this -> redirect('asociaambitos/index');

    }

    public function executeListQuitar(sfWebRequest $request)
    {
        $this  -> forward404Unless($this -> getUser() -> hasAttribute('id_acceso', 'mod_asociaambitos'));
        $this  -> forward404Unless($request -> hasParameter('id_ambito'));

        $acceso = EdaAccesosPeer::retrieveByPK($this -> getUser() -> getAttribute('id_acceso', null, 'mod_asociaambitos'));
        $this -> forward404Unless($acceso instanceof EdaAccesos);

        $ambito = EdaAmbitosPeer::retrieveByPK($request -> getParameter('id_ambito'));

        $acceso -> quitaAmbito($ambito);

        $this -> redirect('asociaambitos/index');
    }

    protected function buildCriteria()
    {
        if (null === $this->filters)
        {
            $this->filters = $this->configuration->getFilterForm($this->getFilters());
        }

        $perfil = EdaPerfilesPeer::retrieveByPK($this -> getUser() -> getAttribute('id_perfil', null, 'mod_asociaambitos'));

        $criteria = $this->filters->buildCriteria($this->getFilters());

        $criteria -> add(EdaPerfilesPeer::ID, $perfil -> getId());
        $criteria -> add(EdaPeriodosPeer::ID_UO, $perfil -> getIdUo());
        $criteria -> addJoin(EdaPeriodosPeer::ID, EdaAmbitosPeer::ID_PERIODO);
        $criteria -> addJoin(EdaAmbitosPeer::ID_AMBITOTIPO, EdaPerfilesPeer::ID_AMBITOTIPO);

        $this->addSortCriteria($criteria);


        $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_criteria'), $criteria);
        $criteria = $event->getReturnValue();

        return $criteria;
    }
}
