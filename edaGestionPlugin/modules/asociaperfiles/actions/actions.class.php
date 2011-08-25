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

require_once dirname(__FILE__).'/../lib/asociaperfilesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/asociaperfilesGeneratorHelper.class.php';

/**
 * asociaperfiles actions.
 *
 * @package    GestionEDAE3
 * @subpackage asociaperfiles
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class asociaperfilesActions extends autoAsociaperfilesActions
{

    protected function buildCriteria()
    {
        if (null === $this->filters)
        {
            $this->filters = $this->configuration->getFilterForm($this->getFilters());
        }

        if(!$this -> getUser() -> hasCredential('EDAGESTIONPLUGIN_administracion'))
        {
            $filtros = $this -> getFilters();
            $filtros['id_uo'] = $this -> getUser() -> getAttribute('idUnidadOrganizativa', null, 'EDAE3User');
            $this -> setFilters($filtros);

            $ws = $this -> filters -> getWidgetSchema();
            unset($ws['id_uo']);
        }

        $criteria = $this->filters->buildCriteria($this->getFilters());

        $this->addSortCriteria($criteria);

        $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_criteria'), $criteria);
        $criteria = $event->getReturnValue();

        return $criteria;
    }

    public function executeIndex(sfWebRequest $request)
    {
        $this -> forward404Unless($request -> hasParameter('id_usuario') || $this -> getUser() -> hasAttribute('id_usuario', 'mod_asociaperfiles'));
        if($request -> hasParameter('id_usuario'))
        {
            $this -> getUser() -> setAttribute('id_usuario', $request -> getParameter('id_usuario'), 'mod_asociaperfiles');
        }
        $this -> usuario = EdaUsuariosPeer::retrieveByPK($this -> getUser() -> getAttribute('id_usuario', null, 'mod_asociaperfiles'));

        $this -> forward404Unless($this -> usuario instanceof EdaUsuarios);

        $this ->setLayout('ventanaNueva');

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
    }

    public function executePerfilesAsociados(sfWebRequest $request)
    {
        $this -> forward404Unless($request -> hasParameter('id_usuario') || $this -> getUser() -> hasAttribute('id_usuario', 'mod_asociaperfiles'));
        if($request -> hasParameter('id_usuario'))
        {
            $this -> getUser() -> setAttribute('id_usuario', $request -> getParameter('id_usuario'), 'mod_asociaperfiles');
        }
        $this -> usuario = EdaUsuariosPeer::retrieveByPK($this -> getUser() -> getAttribute('id_usuario', null, 'mod_asociaperfiles'));

        $this -> forward404Unless($this -> usuario instanceof EdaUsuarios);

        $this -> id_usuario     = $request -> getParameter('id_usuario');

        $c = new Criteria();

        $c -> add(EdaUsuariosPeer::ID, $this->id_usuario);
        $c -> addJoin(EdaUsuariosPeer::ID, EdaAccesosPeer::ID_USUARIO);
        $c -> addJoin(EdaAccesosPeer::ID_PERFIL, EdaPerfilesPeer::ID);
        $c -> addJoin(EdaPerfilesPeer::ID, EdaPerfilesI18nPeer::ID);
        $c -> add(EdaPerfilesI18nPeer::ID_CULTURA, $this -> getUser() -> getCulture());
        $c -> addJoin(EdaPerfilesPeer::ID_UO, EdaUosPeer::ID);
        $c -> addAscendingOrderByColumn(EdaUosPeer::ID);
        $c -> addAscendingOrderByColumn(EdaPerfilesI18nPeer::NOMBRE);

        if(!$this -> getUser() -> hasCredential('EDAGESTIONPLUGIN_administracion'))
        {
            $c -> addJoin(EdaUosPeer::ID,$this -> getUser() -> getAttribute('idUnidadOrganizativa', null, 'EDAE3User'));
        }
        $c -> addAscendingOrderByColumn(EdaUosPeer::ID);

        $this -> perfiles = EdaPerfilesPeer::doSelect($c);
        $this -> linkUsuarios = ($this -> usuario -> esPersona())? 'personas/index' : 'organismos/index';

    }
    public function executeListPoner(sfWebRequest $request)
    {
        $this  -> forward404Unless($this -> getUser() -> hasAttribute('id_usuario', 'mod_asociaperfiles'));
        $this  -> forward404Unless($request -> hasParameter('id'));

        $usuario = EdaUsuariosPeer::retrieveByPK($this -> getUser() -> getAttribute('id_usuario', null, 'mod_asociaperfiles'));
        $this -> forward404Unless($usuario instanceof EdaUsuarios);

        if(!$this -> getUser() -> hasCredential('EDAGESTIONPLUGIN_administracion')) // El usuario solo puede asociar perfiles de su UO

        {
            $idUOSesion = $this -> getUser() -> getAttribute('idUnidadOrganizativa', null, 'EDAE3User');
            $perfilAAsociar = EdaPerfilesPeer::retrieveByPK($request -> getParameter('id'));
            $idUOAAsociar     = $perfilAAsociar -> getEdaUos() -> getId();

            if($idUOSesion != $idUOAAsociar) // Violación de seguridad

            {
                $this -> redirect(sfConfig::get('sf_secure_module').'/'.sfConfig::get('sf_secure_action'));
            }
        }
        $usuario -> ponPerfil($request -> getParameter('id'));

        $this -> redirect('asociaperfiles/index');

    }

    public function executeListQuitar(sfWebRequest $request)
    {
        $this  -> forward404Unless($this -> getUser() -> hasAttribute('id_usuario', 'mod_asociaperfiles'));
        $this  -> forward404Unless($request -> hasParameter('id'));

        $usuario = EdaUsuariosPeer::retrieveByPK($this -> getUser() -> getAttribute('id_usuario', null, 'mod_asociaperfiles'));
        $this -> forward404Unless($usuario instanceof EdaUsuarios);

        if(!$this -> getUser() -> hasCredential('EDAGESTIONPLUGIN_administracion')) // El usuario solo puede asociar perfiles de su UO

        {
            $idUOSesion = $this -> getUser() -> getAttribute('idUnidadOrganizativa', null, 'EDAE3User');
            $perfilAAsociar = EdaPerfilesPeer::retrieveByPK($request -> getParameter('id'));
            $idUOAAsociar     = $perfilAAsociar -> getEdaUos() -> getId();

            if($idUOSesion != $idUOAAsociar) // Violación de seguridad

            {
                $this -> redirect(sfConfig::get('sf_secure_module').'/'.sfConfig::get('sf_secure_action'));
            }
        }
        $usuario -> quitaPerfil($request -> getParameter('id'));

        $this -> redirect('asociaperfiles/index');
    }

    function executeMostrarPerfilesAsociados(sfWebRequest $request)
    {
        $this  -> forward404Unless($request -> hasParameter('id_usuario'));

        $filtros = $this -> getUser() -> getAttribute('asociaperfiles.filters', null, 'admin_module');


        $id_uo = (isset($filtros['id_uo']))? $filtros['id_uo'] : '' ;
        $this -> id_usuario     = $request -> getParameter('id_usuario');

        $c = new Criteria();

        $c -> add(EdaUsuariosPeer::ID, $this->id_usuario);
        $c -> addJoin(EdaUsuariosPeer::ID, EdaAccesosPeer::ID_USUARIO);
        $c -> addJoin(EdaAccesosPeer::ID_PERFIL, EdaPerfilesPeer::ID);
        $c -> addJoin(EdaPerfilesPeer::ID_UO, EdaUosPeer::ID);
        if($id_uo != '')
        {
            $c -> addJoin(EdaUosPeer::ID,$id_uo );

        }
        if(!$this -> getUser() -> hasCredential('EDAGESTIONPLUGIN_administracion'))
        {
            $c -> addJoin(EdaUosPeer::ID,$this -> getUser() -> getAttribute('idUnidadOrganizativa', null, 'EDAE3User'));
        }
        $c -> addAscendingOrderByColumn(EdaUosPeer::ID);

        $this -> perfiles = EdaPerfilesPeer::doSelect($c);

    }

    function executeOcultarPerfilesAsociados(sfWebRequest $request)
    {
        $this  -> forward404Unless($request -> hasParameter('id_usuario'));
        $this  -> id_usuario =$request -> getParameter('id_usuario');
    }

    function executeQuitarAmbito(sfWebRequest $request)
    {
        $this -> forward404Unless($request -> hasParameter('id_ambito') && $request -> hasParameter('id_usuario'));

        $c = new Criteria();
        $c -> add(EdaAccesoAmbitoPeer::ID_AMBITO, $request -> getParameter('id_ambito'));
        $c -> addJoin(EdaAccesoAmbitoPeer::ID_ACCESO, EdaAccesosPeer::ID);
        $c -> add(EdaAccesosPeer::ID_USUARIO,$request -> getParameter('id_usuario'));

        $acceso_ambito = EdaAccesoAmbitoPeer::doSelectOne($c);

        $acceso_ambito -> delete();

        $this -> redirect('asociaperfiles/perfilesAsociados?id_usuario='.$request -> getParameter('id_usuario'));
    }
}
