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

require_once dirname(__FILE__).'/../lib/periodoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/periodoGeneratorHelper.class.php';

/**
 * periodos actions.
 *
 * @package    GestionEDAE3
 * @subpackage periodos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class periodoActions extends autoPeriodoActions
{
    protected function buildCriteria()
    {
        if (null === $this->filters)
        {
            $this->filters = $this->configuration->getFilterForm($this->getFilters());
        }

        $criteria = $this->filters->buildCriteria($this->getFilters());

        $filtros = $this->getFilters();
        if (array_key_exists('estado', $filtros) && $filtros['estado']!= -1)
        {
            if ($filtros['estado']=='ACTIVO')
                $criteria -> add(SftPeriodoPeer::ESTADO, 'ACTIVO');
            elseif($filtros['estado']=='INACTIVO')
                $criteria -> add(SftPeriodoPeer::ESTADO, 'INACTIVO');
        }

        $this->addSortCriteria($criteria);

        $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_criteria'), $criteria);
        $criteria = $event->getReturnValue();

        return $criteria;
    }


    public function executeNew(sfWebRequest $request)
    {
        parent::executeNew($request);

        $periodos_filter = $this -> getUser() -> getAttribute('periodo.filters', null, 'admin_module');

        if(isset($periodos_filter['id_uo']))
        {
            $this -> form -> setDefault('id_uo', $periodos_filter['id_uo']);
        }

    }
}
