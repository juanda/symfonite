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
class EdaOrganismosConTelEmailDirForm extends BaseEdaOrganismosForm
{
    public function configure()
    {
        $this -> getWidget('created_at') -> setOption('date', array('format' => '%day% - %month% - %year%'));
        $this -> getWidget('updated_at') -> setOption('date', array('format' => '%day% - %month% - %year%'));

        if (!$this->isNew())
        {
            $sfUser = $this -> getObject() -> getSfUser();
            $sfUserForm = new EdaUserNameForm($sfUser);
            $this -> embedForm('identificacion', $sfUserForm);
            // embed all subcategory forms
            foreach ($this->getObject()->getEdaTelefonoss() as $telefono)
            {
                $telefono_form = new EdaTelefonosForm($telefono);
                $this->embedForm('telefono'.$telefono->getId(), $telefono_form);
                $this->widgetSchema['telefono'.$telefono->getId()]->setLabel('Teléfono');
                $this -> widgetSchema['telefono'.$telefono->getId()]['numerotelefono'] = new sfWidgetFormInputDelete(array(
                                'url' => 'organismos/borraTelefono',
                                'model_id' => $telefono->getId(),
                                'confirm' => '¿Estás seguro?'));
            }


            $telefono_form = new EdaTelefonosForm(null, array('id_organismo' => $this-> getObject() -> getId()));
            $this->embedForm('telefono', $telefono_form);

            foreach($this -> getObject() -> getEdaEmailss() as $email)
            {
                $email_form = new EdaEmailsForm($email);
                $this -> embedForm('email'.$email -> getId(), $email_form);
                $this->widgetSchema['email'.$email->getId()]->setLabel('E-mail');
                $this -> widgetSchema['email'.$email->getId()]['direccion'] = new sfWidgetFormInputDelete(array(
                                'url' => 'organismos/borraEmail',
                                'model_id' => $email->getId(),
                                'confirm' => '¿Estás seguro?'));
            }

            $email_form = new EdaEmailsForm(null, array('id_organismo' => $this-> getObject() -> getId()));
            $this->embedForm('email', $email_form);

            foreach($this -> getObject() -> getEdaDireccioness() as $direccion)
            {
                $direccion_form = new EdaDireccionesForm($direccion);
                $this -> embedForm('direccion'.$direccion -> getId(), $direccion_form);
                $this->widgetSchema['direccion'.$direccion->getId()]->setLabel('Dirección');
                $this -> widgetSchema['direccion'.$direccion->getId()]['domicilio'] = new sfWidgetFormInputDelete(array(
                                'url' => 'organismos/borraDireccion',
                                'model_id' => $direccion->getId(),
                                'confirm' => '¿Estás seguro?'));
            }

            $direccion_form = new EdaDireccionesForm(null, array('id_organismo' => $this-> getObject() -> getId()));
            $this->embedForm('direccion', $direccion_form);
        }
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
}
