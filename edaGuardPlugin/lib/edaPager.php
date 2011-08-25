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
/*
 *
 */

/**
 * Description of edaPager
 *
 * @author carlos
 */
class edaPager extends sfPager
{
  protected 
    $arraydatos = null,
    $nReg = null;

  public function __construct($arraydatos, $maxPerPage = 10, $nReg=null)
  {
    parent::__construct(null, $maxPerPage);
    $this->arraydatos = $arraydatos;
    if($nReg==null) $this->nb = count($arraydatos);
    else $this->nb = $nReg;
  }

  public function init()
  {
    $hasMaxRecordLimit = ($this->getMaxRecordLimit() !== false);
    $maxRecordLimit = $this->getMaxRecordLimit();

    $cForCount = null;

    $this->setNbResults($this->nb);

    $c = null;

    if (($this->getPage() == 0 || $this->getMaxPerPage() == 0))
    {
      $this->setLastPage(0);
    }
    else
    {
      $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));

      $offset = ($this->getPage() - 1) * $this->getMaxPerPage();
    }
  }

  protected function retrieveObject($offset)
  {
    $nIni = ($offset+1)*$this->getMaxPerPage();
    $nNum = $this->getMaxPerPage();
    return array_slice($this->arraydatos,$nIni,$nNum,true);
  }

  public function getResults()
  {
    $nIni = ($this->getPage()-1)*$this->getMaxPerPage();
    $nNum = $this->getMaxPerPage();
    return array_slice($this->arraydatos,$nIni,$nNum,true);
  }

  public function getNext()
  {
    $nIni = ($this->getPage())*$this->getMaxPerPage();
    $nNum = $this->getMaxPerPage();
    return array_slice($this->arraydatos,$nIni,$nNum,true);
  }

  public function getPrevious()
  {
    $nIni = ($this->getPage()-2)*$this->getMaxPerPage();
    $nNum = $this->getMaxPerPage();
    return array_slice($this->arraydatos,$nIni,$nNum,true);
  }

}
?>