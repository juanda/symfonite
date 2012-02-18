<?php

require_once dirname(__FILE__).'/../lib/asociaatributosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/asociaatributosGeneratorHelper.class.php';

/**
 * asociaatributos actions.
 *
 * @package    LaMadraza
 * @subpackage asociaatributos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class asociaatributosActions extends autoAsociaatributosActions
{

   public function preExecute()
    {
        parent::preExecute();

        $this->setLayout('ventanaNueva');

        $atributo_filter = $this->getUser()->getAttribute('asociaatributos.filters', null, 'admin_module');

        $this->usuario = SftUsuarioPeer::retrieveByPK($atributo_filter['id_usuario']);                
        
    }

    public function executeIndex(sfWebRequest $request)
    {
        parent::executeIndex($request);
        $this->filters->setDefault('id_usuario', $this->usuario->getId());
    }

    public function executeNew(sfWebRequest $request)
    {
        parent::executeNew($request);

        $this->form->setDefault('id_usuario', $this->usuario->getId());
    }

    public function executeFilter(sfWebRequest $request)
    {

        $this->setPage(1);

        if ($request->hasParameter('_reset'))
        {
            $this->setFilters(array('id_usuario' => $this->usuario->getId()));

            $this->redirect('@sft_usu_atributo_valor_asociaatributos');
        }

        $this->filters = $this->configuration->getFilterForm($this->getFilters());

        $this->filters->bind($request->getParameter($this->filters->getName()));
        if ($this->filters->isValid())
        {
            $this->setFilters($this->filters->getValues());

            $this->redirect('@sft_usu_atributo_valor_asociaatributos');
        }

        $this->pager = $this->getPager();
        $this->sort = $this->getSort();

        $this->setTemplate('index');
    }


}
