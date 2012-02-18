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

require_once dirname(__FILE__) . '/../lib/asociacredencialesGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/asociacredencialesGeneratorHelper.class.php';

/**
 * asociacredencial actions.
 *
 * @package    GestionEDAE3
 * @subpackage asociacredencial
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class asociacredencialesActions extends autoAsociacredencialesActions
{

    public function executeIndex(sfWebRequest $request)
    {
        $this->forward404Unless($request->hasParameter('id_perfil') || $this->getUser()->hasAttribute('id_perfil', 'mod_asociacredenciales'));

        if ($request->hasParameter('vercred') && !$request->hasParameter('filtro'))
        {
            $filtro = array('sft_perfil_credencial_list' => $request->getParameter('id_perfil'));
            $this->getUser()->setAttribute('asociacredenciales.filters', $filtro, 'admin_module');
        } elseif ($request->hasParameter('asociacred') && !$request->hasParameter('filtro'))
        {
            $this->getUser()->setAttribute('asociacredenciales.filters', null, 'admin_module');
        }
//        echo '<pre>';
//        print_r($this->getFilters());
//        echo '</pre>';
//        exit;

        if ($request->hasParameter('id_perfil'))
        {
            $this->getUser()->setAttribute('id_perfil', $request->getParameter('id_perfil'), 'mod_asociacredenciales');
        }


        $this->perfil = SftPerfilPeer::retrieveByPK($this->getUser()->getAttribute('id_perfil', null, 'mod_asociacredenciales'));

        $this->forward404Unless($this->perfil instanceof SftPerfil);
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

        $this->setLayout('ventanaNueva');
    }

//    public function executeFilter(sfWebRequest $request)
//    {
//        $this->setPage(1);
//
//        $query_string= ($request -> hasParameter('asociacred'))?
//                '?id_perfil='.$request -> getParameter('id_perfil').'&asociacred=true' :
//                '?id_perfil='.$request -> getParameter('id_perfil').'&vercred=true';
//
//        if ($request->hasParameter('_reset'))
//        {
//            $this->setFilters($this->configuration->getFilterDefaults());
//
//            $this->redirect('asociacredencial/index'.$query_string);
//        }
//
//        $this->filters = $this->configuration->getFilterForm($this->getFilters());
//        $filtro = $request->getParameter($this->filters->getName());
//
//
//        if($request -> hasParameter('vercred'))
//        {
//            $filtro['sft_perfil_credencial_list'] = $request -> getParameter('id_perfil');
//        }
//
//        $this->filters->bind($filtro);
//        if ($this->filters->isValid())
//        {
//            $this->setFilters($this->filters->getValues());
//
//            $this->redirect('asociacredencial/index'.$query_string);
//        }
//
//        $this->pager = $this->getPager();
//        $this->sort = $this->getSort();
//
//        $this->setTemplate('index');
//    }


    public function executeFilter(sfWebRequest $request)
    {
        $this->setPage(1);

        $query_string = ($request->hasParameter('asociacred')) ?
                '?id_perfil=' . $request->getParameter('id_perfil') . '&asociacred=true&filtro=true' :
                '?id_perfil=' . $request->getParameter('id_perfil') . '&vercred=true&filtro=true';


        if ($request->hasParameter('_reset'))
        {
            $this->setFilters($this->configuration->getFilterDefaults());

            $this->redirect('asociacredenciales/index' . $query_string);
        }

        $this->filters = $this->configuration->getFilterForm($this->getFilters());
        $filtro = $request->getParameter($this->filters->getName());

        $this->filters->bind($filtro);

        if ($this->filters->isValid())
        {

            $this->setFilters($this->filters->getValues());

            $this->redirect('asociacredenciales/index' . $query_string);
        } else
        {
           echo $this->filters->renderGlobalErrors();exit; 
        }

        $this->pager = $this->getPager();
        $this->sort = $this->getSort();

        $this->setTemplate('index');
    }

    public function executeListPoner(sfWebRequest $request)
    {
        $this->forward404Unless($this->getUser()->hasAttribute('id_perfil', 'mod_asociacredenciales'));
        $this->forward404Unless($request->hasParameter('id'));

        $id_perfil = $this->getUser()->getAttribute('id_perfil', null, 'mod_asociacredenciales');
        $perfil = SftPerfilPeer::retrieveByPK($id_perfil);
        $this->forward404Unless($perfil instanceof SftPerfil);

        $perfil->ponCredencial($request->getParameter('id'));

        $this->redirect('asociacredenciales/index?asociacred=true&filtro=true&id_perfil=' . $id_perfil);

        $this->setLayout('ventanaNueva');
    }

    public function executeListQuitar(sfWebRequest $request)
    {
        $this->forward404Unless($this->getUser()->hasAttribute('id_perfil', 'mod_asociacredenciales'));
        $this->forward404Unless($request->hasParameter('id'));

        $id_perfil = $this->getUser()->getAttribute('id_perfil', null, 'mod_asociacredenciales');
        $perfil = SftPerfilPeer::retrieveByPK($id_perfil);
        $this->forward404Unless($perfil instanceof SftPerfil);

        $perfil->quitaCredencial($request->getParameter('id'));

        $this->redirect('asociacredenciales/index?asociacred=true&filtro=true&id_perfil=' . $id_perfil);

        $this->setLayout('ventanaNueva');
    }

    function executeMostrarcredencialAsociadas(sfWebRequest $request)
    {
        $this->forward404Unless($request->hasParameter('id_perfil'));

        $filtros = $this->getUser()->getAttribute('asociacredenciales.filters', null, 'admin_module');


        $id_aplicacion = (isset($filtros['id_aplicacion'])) ? $filtros['id_aplicacion'] : '';
        $this->id_perfil = $request->getParameter('id_perfil');

        $c = new Criteria();

        $c->add(SftPerfilPeer::ID, $this->id_perfil);
        $c->addJoin(SftPerfilPeer::ID, SftPerfilCredencialPeer::ID_PERFIL);
        $c->addJoin(SftPerfilCredencialPeer::ID_CREDENCIAL, SftCredencialPeer::ID);
        if ($id_aplicacion != '')
        {
            $c->addJoin(SftCredencialPeer::ID_APLICACION, $id_aplicacion);
        }

        $this->credencial = SftCredencialPeer::doSelect($c);
    }

    function executeOcultarcredencialAsociadas(sfWebRequest $request)
    {
        $this->forward404Unless($request->hasParameter('id_perfil'));
        $this->id_perfil = $request->getParameter('id_perfil');
    }

}
