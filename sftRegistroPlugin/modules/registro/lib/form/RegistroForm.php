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
 * SftPersona form.
 *
 * @package    nosfaltauno
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class RegistroForm extends sfForm {

    public function configure() {
        //$this->widgetSchema['username'] = new sfWidgetFormInput();
        $this->widgetSchema['direccion'] = new sfWidgetFormInput();
        $this->widgetSchema['nombre'] = new sfWidgetFormInput();
        $this->widgetSchema['apellido1'] = new sfWidgetFormInput();
        $this->widgetSchema['apellido2'] = new sfWidgetFormInput();
        $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
        $this->widgetSchema['repassword'] = new sfWidgetFormInputPassword();

        $this->widgetSchema->setNameFormat('registro[%s]');

        //$this->validatorSchema['username'] = new sfValidatorString();
        $this->validatorSchema['direccion'] = new sfValidatorEmail();
        $this->validatorSchema['nombre'] = new sfValidatorString();
        $this->validatorSchema['apellido1'] = new sfValidatorString();
        $this->validatorSchema['apellido2'] = new sfValidatorString();
        $this->validatorSchema['password'] = new sfValidatorString();
        $this->validatorSchema['repassword'] = new sfValidatorString();

        $this->validatorSchema->setPostValidator(
                new sfValidatorAnd(
                        array(
                            new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'repassword', array(), array('invalid' => 'Las contraseñas no coinciden'))
                            , new sfValidatorPropelUnique(array('model' => 'SftEmail', 'column' => 'direccion'), array('invalid' => 'Las dirección de correo ya existe'))
                            //, new sfValidatorPropelUnique(array('model' => 'SfUser', 'column' => 'username'), array('invalid' => 'El usuario ya existe'))
                )));
    }

}