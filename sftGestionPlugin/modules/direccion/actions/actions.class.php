<?php

require_once dirname(__FILE__) . '/../lib/direccionGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/direccionGeneratorHelper.class.php';

/**
 * direccion actions.
 *
 * @package    basico
 * @subpackage direccion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class direccionActions extends autoDireccionActions {

    public function preExecute() {
        parent::preExecute();

        $this->setLayout('ventanaNueva');

        $direccion_filter = $this->getUser()->getAttribute('direccion.filters', null, 'admin_module');

        $this->usuario = SftUsuarioPeer::retrieveByPK($direccion_filter['id_usuario']);
    }

    public function executeIndex(sfWebRequest $request) {
        parent::executeIndex($request);
        $this->filters->setDefault('id_usuario', $this->usuario->getId());
    }

    public function executeNew(sfWebRequest $request) {
        parent::executeNew($request);

        $this->form->setDefault('id_usuario', $this->usuario->getId());
    }

    public function executeFilter(sfWebRequest $request) {

        $this->setPage(1);

        if ($request->hasParameter('_reset')) {
            $this->setFilters(array('id_usuario' => $this->usuario->getId()));

            $this->redirect('@sft_direccion');
        }

        $this->filters = $this->configuration->getFilterForm($this->getFilters());

        $this->filters->bind($request->getParameter($this->filters->getName()));
        if ($this->filters->isValid()) {
            $this->setFilters($this->filters->getValues());

            $this->redirect('@sft_direccion');
        }

        $this->pager = $this->getPager();
        $this->sort = $this->getSort();

        $this->setTemplate('index');
    }

    public function executeListProvincias(sfWebRequest $request) {
        $this->pais = $request->getParameter('pais');

        if ($this->pais == 724) {
            $this->widgetProvincia = new sfWidgetFormPropelChoice(array('model' => 'GenProvincia', 'add_empty' => true));
            $validatorProvincia['provincia'] = new sfValidatorPropelChoice(array('model' => 'GenProvincia', 'column' => 'id', 'required' => false));
        }else{
            $this->widgetProvincia = new sfWidgetFormInputText();
        }
        $this->setLayout(false);
    }

    public function executeListLocalidades(sfWebRequest $request) {
        $this->pais = $request->getParameter('pais');
        $this->provincia = $request->getParameter('provincia');
        if (($this->pais == 724) && !empty($this->provincia)) {
            $c = new Criteria();
            $c->add(GenLocalidadPeer::ID_PROVINCIA, $this->provincia);
            $localidades = GenLocalidadPeer::doSelect($c);
            $this->widgetLocalidad = new sfWidgetFormChoice(array('choices' => $localidades));
            $validatorLocalidad['municipio'] = new sfValidatorChoice(array('choices' => $localidades, 'required' => false));
        }else{
            $this->widgetLocalidad = new sfWidgetFormInputText();
        }
        $this->setLayout(false);
    }

}
