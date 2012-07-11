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

require_once dirname(__FILE__) . '/../lib/ambitoGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/ambitoGeneratorHelper.class.php';

/**
 * ambito actions.
 *
 * @package    GestionEDAE3
 * @subpackage ambito
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class ambitoActions extends autoAmbitoActions {

    public function preExecute() {
        parent::preExecute();
        $this->setLayout('ventanaNueva');
    }

    public function executeIndex(sfWebRequest $request) {
        parent::executeIndex($request);

        $ambitos_filter = $this->getUser()->getAttribute('ambito.filters', null, 'admin_module');

        $ambitotipo = SftAmbitoTipoPeer::retrieveByPK($ambitos_filter['id_ambitotipo']);

        if (!$this->getUser()->hasCredential('SFTGESTIONPLUGIN_administracion')) {

            $this->filters = new SftAmbitoFormFilter(null, array(
                        'idUo' => $this->getUser()->getAttribute('idUnidadOrganizativa', null, 'SftUser')));
        }
        $this->getUser()->setAttribute('ambitotipo', $ambitotipo);
    }

    public function executeNew(sfWebRequest $request) {
        parent::executeNew($request);

        if (!$this->getUser()->hasCredential('SFTGESTIONPLUGIN_administracion')) {

            $this->form = new SftAmbitoForm(null, array(
                        'idUo' => $this->getUser()->getAttribute('idUnidadOrganizativa', null, 'SftUser')));
        }

        $ambitos_filter = $this->getUser()->getAttribute('ambito.filters', null, 'admin_module');

        if (isset($ambitos_filter['id_ambitotipo'])) {
            $this->form->setDefault('id_ambitotipo', $ambitos_filter['id_ambitotipo']);
        }

        $ambitos_filter = $this->getUser()->getAttribute('ambito.filters', null, 'admin_module');
        $ambitotipo = SftAmbitoTipoPeer::retrieveByPK($ambitos_filter['id_ambitotipo']);
        $this->getUser()->setAttribute('ambitotipo', $ambitotipo);
    }

    public function executeEdit(sfWebRequest $request) {
        parent::executeEdit($request);

        if (!$this->getUser()->hasCredential('SFTGESTIONPLUGIN_administracion')) {

            $this->form = new SftAmbitoForm(null, array(
                        'idUo' => $this->getUser()->getAttribute('idUnidadOrganizativa', null, 'SftUser')));
        }
    }

    public function executeCreate(sfWebRequest $request) {
        parent::executeCreate($request);
        $ambitos_filter = $this->getUser()->getAttribute('ambitos.filters', null, 'admin_module');

        if (isset($ambitos_filter['id_ambitotipo'])) {
            $this->form->setDefault('id_ambitotipo', $ambitos_filter['id_ambitotipo']);
        }

        $ambitos_filter = $this->getUser()->getAttribute('ambitos.filters', null, 'admin_module');
        $ambitotipo = SftAmbitoTipoPeer::retrieveByPK($ambitos_filter['id_ambitotipo']);
        $this->getUser()->setAttribute('ambitotipo', $ambitotipo);
    }

    protected function buildCriteria() {
        if (null === $this->filters) {
            $this->filters = $this->configuration->getFilterForm($this->getFilters());
        }


        $criteria = $this->filters->buildCriteria($this->getFilters());

        // Si no tiene la credencial de administración total sólo se les muestra los ámbitos de su uo
        if (!$this->getUser()->hasCredential('SFTGESTIONPLUGIN_administracion')) {
            $idUo = $this->getUser()->getAttribute('idUnidadOrganizativa', null, 'SftUser');
            $criteria->addJoin(SftAmbitoPeer::ID_PERIODO, SftPeriodosPeer::ID);
            $criteria->add(SftPeriodosPeer::ID_UO, $idUo);
        }

        $this->addSortCriteria($criteria);

        $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_criteria'), $criteria);
        $criteria = $event->getReturnValue();

        return $criteria;
    }

    public function executeDelete(sfWebRequest $request) {
        $request->checkCSRFProtection();


        if (!strcmp($request->getParameter('id'), $this->getUser()->getAttribute('idAmbito', null, 'SftUser'))) {
            $this->getUser()->setFlash('error', 'No se puede borrar el ambito que está actuálmente asociado a la persona');
        } else {
            $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

            $this->getRoute()->getObject()->delete();

            $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
        }
        $this->redirect('@sft_ambito');
    }

}
