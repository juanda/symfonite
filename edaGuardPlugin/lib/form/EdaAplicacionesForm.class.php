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
 * EdaAplicaciones form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class EdaAplicacionesForm extends BaseEdaAplicacionesForm
{
    public function configure()
    {
        $this -> widgetSchema['id_credencial'] = new sfWidgetFormInputHidden();
        $this -> widgetSchema['descripcion']   = new sfWidgetFormTextArea();
        $this -> widgetSchema['logotipo']      = new sfWidgetFormInputFile();

        $this -> validatorSchema['codigo'] =  new sfValidatorAnd(array(
                        new sfValidatorString(array('max_length' => 250)),
                        new sfValidatorRegex(array('pattern' => '/^[a-zA-Z0-9_]{3,255}$/'), array('invalid' => 'No se permiten espacios'))
        ));
        $this -> validatorSchema['logotipo'] = new sfValidatorFile(
                array('max_size' => '100000', 'mime_types' => 'web_images', 'required' => false),
                array('max_size' => 'Ha superado el tamaño de la imagen permitida (%max_size%)', 'mime_types' => 'tipo de fichero no permitido'));
    }
}
