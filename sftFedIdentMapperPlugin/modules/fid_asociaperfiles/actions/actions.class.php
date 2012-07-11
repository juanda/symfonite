<?php

require_once dirname(__FILE__) . '/../lib/fid_asociaperfilesGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/fid_asociaperfilesGeneratorHelper.class.php';

/**
 * fid_asociaperfiles actions.
 *
 * @package    basico
 * @subpackage fid_asociaperfiles
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class fid_asociaperfilesActions extends autoFid_asociaperfilesActions
{

    public function executeIndex(sfWebRequest $request)
    {
        $this->forward404Unless($request->hasParameter('id_atributo') || $this->getUser()->hasAttribute('id_atributo', 'mod_asociaperfiles'));

        parent::executeIndex($request);

        $this->getUser()->setAttribute('id_atributo', $request->getParameter('id_atributo'), 'mod_asociaperfiles');
        $this->setLayout('ventanaNueva');
    }

    public function executeFilter(sfWebRequest $request)
    {
        $this->setPage(1);

        $query_string = '?id_atributo=' . $this->getUser()->getAttribute('id_atributo', null, 'mod_asociaperfiles');

        if ($request->hasParameter('_reset'))
        {
            $this->setFilters($this->configuration->getFilterDefaults());

            $this->redirect('@sft_perfil_fid_asociaperfiles' . $query_string);
        }

        $this->filters = $this->configuration->getFilterForm($this->getFilters());

        $this->filters->bind($request->getParameter($this->filters->getName()));
        if ($this->filters->isValid())
        {
            $this->setFilters($this->filters->getValues());

            $this->redirect('@sft_perfil_fid_asociaperfiles' . $query_string);
        }

        $this->pager = $this->getPager();
        $this->sort = $this->getSort();

        $this->setTemplate('index');
    }

    public function executeListPoner(sfWebRequest $request)
    {
        $this->forward404Unless($this->getUser()->hasAttribute('id_atributo', 'mod_asociaperfiles'));
        $this->forward404Unless($request->hasParameter('id'));

        $id_atributo = $this->getUser()->getAttribute('id_atributo', null, 'mod_asociaperfiles');
        $atributo = SftFidAtributoPeer::retrieveByPK($id_atributo);
        $this->forward404Unless($atributo instanceof SftFidAtributo);

        $atributo->ponPerfil($request->getParameter('id'));

        $this->redirect('@sft_perfil_fid_asociaperfiles?id_atributo=' . $id_atributo);

        $this->setLayout('ventanaNueva');
    }

    public function executeListQuitar(sfWebRequest $request)
    {
        $this->forward404Unless($this->getUser()->hasAttribute('id_atributo', 'mod_asociaperfiles'));
        $this->forward404Unless($request->hasParameter('id'));

        $id_atributo = $this->getUser()->getAttribute('id_atributo', null, 'mod_asociaperfiles');
        $atributo = SftFidAtributoPeer::retrieveByPK($id_atributo);
        $this->forward404Unless($atributo instanceof SftFidAtributo);

        $atributo->quitaPerfil($request->getParameter('id'));

        $this->redirect('@sft_perfil_fid_asociaperfiles?id_atributo=' . $id_atributo);

        $this->setLayout('ventanaNueva');
    }

}
