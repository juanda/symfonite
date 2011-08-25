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
 * EdaAmbitos form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class EdaAmbitosForm extends BaseEdaAmbitosForm
{
    public function configure()
    {
        unset($this -> widgetSchema['eda_acceso_ambito_list']);
        unset($this -> validatorSchema['eda_acceso_ambito_list']);
        
        $c = new Criteria();


        if(!is_null($this -> getOption('idUo', null)))
        {
            $c -> add(EdaPeriodosPeer::ID_UO, $this -> getOption('idUo'));
        }

        $this -> widgetSchema['id_periodo'] = new sfWidgetFormPropelChoice(array(
                        'model'     => 'EdaPeriodos',
                        'criteria'  => $c,
                        'add_empty' => false));

        $this -> validatorSchema['id_periodo'] = new sfValidatorPropelChoice(array(
                        'required' => false,
                        'model'    => 'EdaPeriodos',
                        'criteria' => $c,
                        'column'   => 'id'));

        EmbedI18n::aniadeTraducciones($this);
    }
}
