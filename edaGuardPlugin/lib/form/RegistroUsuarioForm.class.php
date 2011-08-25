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
 * EdaPersonas form.
 *
 * @package    nosfaltauno
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class RegistroUsuarioForm extends sfForm
{
    public function configure()
    {
        $this -> widgetSchema['email'] = new sfWidgetFormInput();
        $this -> widgetSchema['username'] = new sfWidgetFormInput();
        $this -> widgetSchema['password'] = new sfWidgetFormInput();
        $this -> widgetSchema['repassword'] = new sfWidgetFormInput();
		
		$this->widgetSchema->setNameFormat('registro[%s]');

		$this->validatorSchema['email'] = new sfValidatorEmail();
		$this->validatorSchema['username'] = new sfValidatorEmail();
		$this->validatorSchema['password'] = new sfValidatorEmail();
		$this->validatorSchema['repassword'] = new sfValidatorEmail();
		
    }
}