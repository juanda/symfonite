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
class SftsfGuardUserForm extends sfGuardUserForm
{
    public function configure()
    {
        parent::configure();

        $this->setValidators(array(
          'username' => new sfValidatorString(array('max_length' => 128,'min_length'=>4),
        array('max_length' => 'Nombre de usuario demasiado largo.','min_length' => 'Nombre de usuario corto, 4 carácters como mínimo.',
            'required' => 'Requerido.')),
          'password' => new sfValidatorString(
            array('max_length' => 128,'min_length'=>4),
            array('max_length'=> 'Contraseña demasiado larga.','min_length'=>'Contraseña corta, 4 carácteres como mínimo.',
            'required'=>'Requerido.')),        
        ));
        
        $this->mergePostValidator(new sfValidatorSchemaCompare
            ('password',
             sfValidatorSchemaCompare::EQUAL,
             'password_again',
             array(), array('invalid' => 'Las contraseñas deben coincidir.')));

        $this->widgetSchema->setLabels(array(
          'username'=>'Nombre de usuario',
          'password'=>'Contraseña',
        'password_again'=>'Repita la nueva contraseña'
        ));
        
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('SftsfGuardUserForm');
    }
    
    public function validarSoloUsuario(){
        $validatorUser = $this->getValidator('username');
        $this->setValidatorSchema(new sfValidatorSchema());
        $this->setValidator('username',$validatorUser);
    }
    
    public function validarSoloPass(){
        $validatorPass = $this->getValidator('password');
        $this->setValidatorSchema(new sfValidatorSchema());
        $this->setValidator('password',$validatorPass);
        $this->setValidator('password_again',clone $validatorPass);
        $this->mergePostValidator(new sfValidatorSchemaCompare
            ('password',
             sfValidatorSchemaCompare::EQUAL,
             'password_again',
             array(), array('invalid' => 'Las contraseñas deben coincidir.')));
    }
} 
