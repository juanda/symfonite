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

require_once dirname(__FILE__) . '/../lib/credencialGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/credencialGeneratorHelper.class.php';

/**
 * credenciales actions.
 *
 * @package    GestionEDAE3
 * @subpackage credenciales
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class credencialActions extends autoCredencialActions
{

    public function preExecute()
    {
        parent::preExecute();

        $this->setLayout('ventanaNueva');

        $credencial_filter = $this->getUser()->getAttribute('credencial.filters', null, 'admin_module');

        $this->aplicacion = SftAplicacionPeer::retrieveByPK($credencial_filter['id_aplicacion']);
    }

    public function executeIndex(sfWebRequest $request)
    {
        parent::executeIndex($request);
        $this->filters->setDefault('id_aplicacion', $this->aplicacion->getId());
    }

    public function executeNew(sfWebRequest $request)
    {
        parent::executeNew($request);

        $this->form->setDefault('id_aplicacion', $this->aplicacion->getId());
    }

    public function executeFilter(sfWebRequest $request)
    {
        
        $this->setPage(1);

        if ($request->hasParameter('_reset'))
        {
            $this->setFilters(array('id_aplicacion'=>$this->aplicacion->getId()));

            $this->redirect('@sft_credencial');
        }

        $this->filters = $this->configuration->getFilterForm($this->getFilters());

        $this->filters->bind($request->getParameter($this->filters->getName()));
        if ($this->filters->isValid())
        {
            $this->setFilters($this->filters->getValues());

            $this->redirect('@sft_credencial');
        }

        $this->pager = $this->getPager();
        $this->sort = $this->getSort();

        $this->setTemplate('index');
    }

    public function executeDelete(sfWebRequest $request)
    {
        $id_credencial = $request->getParameter('id');

        $c = new Criteria();
        $c->add(SftAplicacionPeer::ID_CREDENCIAL, $id_credencial);

        $num_aplicaciones = SftAplicacionPeer::doCount($c);

        // La credencial que se quiere borrar es una credencial de acceso y
        // no se debe borrar hasta que no se elimine la aplicación
        if ($num_aplicaciones > 0)
        {
            $this->getUser()->setFlash('notice', "This is an application credential and can't be deleted");
            $this->redirect('@sft_credenciales');
        }

        parent::executeDelete($request);
    }

}
