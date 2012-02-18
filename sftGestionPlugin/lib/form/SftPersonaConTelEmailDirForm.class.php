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

class SftPersonaConTelEmailDirForm extends BaseSftPersonaForm
{
    public function configure()
    {
        $this -> widgetSchema['observaciones']   = new sfWidgetFormTextArea();

        $years = range(1900, date('Y'));
        $this -> widgetSchema['fechanacimiento'] = new sfWidgetFormDate(
                array('years' => array_combine($years, $years))
        );

        if($this -> isNew())
        {
            $this -> widgetSchema['email']    = new sfWidgetFormInput();

            $this -> validatorSchema['email'] = new sfValidatorEmail();
        }

        if (!$this->isNew())
        {
            $sfUser = $this -> getObject() -> getSfUser();
            $sfUserForm = new SftUserNameForm($sfUser);
            $this -> embedForm('identificacion', $sfUserForm);
        }
//            
            // embed all subcategory forms
        
  
            foreach ($this->getObject()->getSftTelefonos() as $telefono)
            {
                $telefono_form = new SftTelefonoForm($telefono);
                $this->embedForm('telefono'.$telefono->getId(), $telefono_form);
                $this->widgetSchema['telefono'.$telefono->getId()]->setLabel('Teléfono');
                $this -> widgetSchema['telefono'.$telefono->getId()]['numerotelefono'] = new sfWidgetFormInputDelete(array(
                                'url' => 'persona/borraTelefono',
                                'model_id' => $telefono->getId(),
                                'confirm' => '¿Estás seguro?'));
            }
            
            $telefono_form = new SftTelefonoForm(null, array('id_persona' => $this-> getObject() -> getId()));
            $this->embedForm('telefono', $telefono_form);

            foreach($this -> getObject() -> getSftEmails() as $email)
            {
                $email_form = new SftEmailForm($email);
                $this -> embedForm('email'.$email -> getId(), $email_form);
                $this->widgetSchema['email'.$email->getId()]->setLabel('E-mail');
                $this -> widgetSchema['email'.$email->getId()]['direccion'] = new sfWidgetFormInputDelete(array(
                                'url' => 'persona/borraEmail',
                                'model_id' => $email->getId(),
                                'confirm' => '¿Estás seguro?'));
            }

            $email_form = new SftEmailForm(null, array('id_persona' => $this-> getObject() -> getId()));
            $this->embedForm('email', $email_form);

            foreach($this -> getObject() -> getSftDireccions() as $direccion)
            {
                $direccion_form = new SftDireccionForm($direccion);
                $this -> embedForm('direccion'.$direccion -> getId(), $direccion_form);
                $this->widgetSchema['direccion'.$direccion->getId()]->setLabel('Dirección');
                $this -> widgetSchema['direccion'.$direccion->getId()]['domicilio'] = new sfWidgetFormInputDelete(array(
                                'url' => 'persona/borraDireccion',
                                'model_id' => $direccion->getId(),
                                'confirm' => '¿Estás seguro?'));
            }

            $direccion_form = new SftDireccionForm(null, array('id_persona' => $this-> getObject() -> getId()));
            $this->embedForm('direccion', $direccion_form);
        
    }

    public function bind(array $taintedValues = null, array $taintedFiles = null)
    {
        if (!$this -> isNew())
        {
            // remove the embedded new form if the name field was not provided
            if (is_null($taintedValues['telefono']['numerotelefono']) || strlen($taintedValues['telefono']['numerotelefono']) === 0 )
            {
                unset($this->embeddedForms['telefono'], $taintedValues['telefono']);
                // pass the new form validations
                $this->validatorSchema['telefono'] = new sfValidatorPass();
            } else
            {
                // set the category of the new subcategory form object
                $this->embeddedForms['telefono']->getObject()->
                        setNumeroTelefono($this->getObject());
            }
        
            // remove the embedded new form if the name field was not provided
            if (is_null($taintedValues['email']['direccion']) || strlen($taintedValues['email']['direccion']) === 0 )
            {
                unset($this->embeddedForms['email'], $taintedValues['email']);
                // pass the new form validations
                $this->validatorSchema['email'] = new sfValidatorPass();
            } else
            {
                // set the category of the new subcategory form object
                $this->embeddedForms['email']->getObject()->
                        setDireccion($this->getObject());
            }

            if (is_null($taintedValues['direccion']['domicilio']) || strlen($taintedValues['direccion']['domicilio']) === 0 )
            {
                unset($this->embeddedForms['direccion'], $taintedValues['direccion']);
                // pass the new form validations
                $this->validatorSchema['direccion'] = new sfValidatorPass();
            } else
            {
                // set the category of the new subcategory form object
                $this->embeddedForms['direccion']->getObject()->
                        setDomicilio($this->getObject());
            }
        }
        // call parent bind method
        parent::bind($taintedValues, $taintedFiles);

    }

    public function save($con = null)
    {
        $object = parent::save($con);

        if($this -> isNew())
        {
            $email = new SftEmail();
            $email -> setDireccion($this -> getValue('email'));
            $email -> setIdPersona($this -> getObject() -> getId());
            $email -> setPredeterminado(1);
            $email -> save();            
        }

        return $object;
    }
}
