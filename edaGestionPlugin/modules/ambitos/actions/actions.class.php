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

require_once dirname(__FILE__) . '/../lib/ambitosGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/ambitosGeneratorHelper.class.php';

/**
 * ambitos actions.
 *
 * @package    GestionEDAE3
 * @subpackage ambitos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class ambitosActions extends autoAmbitosActions
{

    public function executeIndex(sfWebRequest $request)
    {
        parent::executeIndex($request);

        $ambitos_filter = $this->getUser()->getAttribute('ambitos.filters', null, 'admin_module');

        $this->ambitotipo = EdaAmbitostiposPeer::retrieveByPK($ambitos_filter['id_ambitotipo']);

        if (!$this->getUser()->hasCredential('EDAGESTIONPLUGIN_administracion'))
        {

            $this->filters = new EdaAmbitosFormFilter(null, array(
                        'idUo' => $this->getUser()->getAttribute('idUnidadOrganizativa', null, 'EDAE3User')));
        }
    }

    public function executeNew(sfWebRequest $request)
    {
        parent::executeNew($request);

        if (!$this->getUser()->hasCredential('EDAGESTIONPLUGIN_administracion'))
        {

            $this->form = new EdaAmbitosForm(null, array(
                        'idUo' => $this->getUser()->getAttribute('idUnidadOrganizativa', null, 'EDAE3User')));
        }

        $ambitos_filter = $this->getUser()->getAttribute('ambitos.filters', null, 'admin_module');

        if (isset($ambitos_filter['id_ambitotipo']))
        {
            $this->form->setDefault('id_ambitotipo', $ambitos_filter['id_ambitotipo']);
        }

        $ambitos_filter = $this->getUser()->getAttribute('ambitos.filters', null, 'admin_module');
        $this->ambitotipo = EdaAmbitostiposPeer::retrieveByPK($ambitos_filter['id_ambitotipo']);
    }

    public function executeEdit(sfWebRequest $request)
    {
        parent::executeEdit($request);

        if (!$this->getUser()->hasCredential('EDAGESTIONPLUGIN_administracion'))
        {

            $this->form = new EdaAmbitosForm(null, array(
                        'idUo' => $this->getUser()->getAttribute('idUnidadOrganizativa', null, 'EDAE3User')));
        }
    }

    public function executeCreate(sfWebRequest $request)
    {      
        parent::executeCreate($request);
        $ambitos_filter = $this->getUser()->getAttribute('ambitos.filters', null, 'admin_module');

        if (isset($ambitos_filter['id_ambitotipo']))
        {
            $this->form->setDefault('id_ambitotipo', $ambitos_filter['id_ambitotipo']);
        }

        $ambitos_filter = $this->getUser()->getAttribute('ambitos.filters', null, 'admin_module');
        $this->ambitotipo = EdaAmbitostiposPeer::retrieveByPK($ambitos_filter['id_ambitotipo']);
    }

    protected function buildCriteria()
    {
        if (null === $this->filters)
        {
            $this->filters = $this->configuration->getFilterForm($this->getFilters());
        }


        $criteria = $this->filters->buildCriteria($this->getFilters());

        // Si no tiene la credencial de administración total sólo se les muestra los ámbitos de su uo
        if (!$this->getUser()->hasCredential('EDAGESTIONPLUGIN_administracion'))
        {
            $idUo = $this->getUser()->getAttribute('idUnidadOrganizativa', null, 'EDAE3User');
            $criteria->addJoin(EdaAmbitosPeer::ID_PERIODO, EdaPeriodosPeer::ID);
            $criteria->add(EdaPeriodosPeer::ID_UO, $idUo);
        }

        $this->addSortCriteria($criteria);

        $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_criteria'), $criteria);
        $criteria = $event->getReturnValue();

        return $criteria;
    }

}
