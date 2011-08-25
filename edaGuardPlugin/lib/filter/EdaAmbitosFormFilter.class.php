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

/**
 * EdaAmbitos filter form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class EdaAmbitosFormFilter extends BaseEdaAmbitosFormFilter
{
  public function configure($options=null)
  {
      $c = new Criteria();

    
      if(!is_null($this -> getOption('idUo', null)))
      {   
          $c -> add(EdaPeriodosPeer::ID_UO, $this -> getOption('idUo'));
      }
      unset($this -> widgetSchema['eda_acceso_ambito_list']);
      unset($this -> validatorSchema['eda_acceso_ambito_list']);

      $this -> widgetSchema['id_ambitotipo'] =  new sfWidgetFormPropelChoice(array('model' => 'EdaAmbitostipos', 'add_empty' => false));

      $this -> widgetSchema['id_periodo'] = new sfWidgetFormPropelChoice(array(
          'model'     => 'EdaPeriodos',
          'criteria'  => $c,
          'add_empty' => true));

      $this -> validatorSchema['id_periodo'] = new sfValidatorPropelChoice(array(
          'required' => false,
          'model'    => 'EdaPeriodos',
          'criteria' => $c,
          'column'   => 'id'));

  }
}
