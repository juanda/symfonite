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

class SftOrganismoConIdentEmailForm extends SftOrganismoForm
{
    public function configure()
    {
        $this -> widgetSchema['descripcion']   = new sfWidgetFormTextArea();       
        unset ($this -> widgetSchema['correo']);
        $this->widgetSchema['updated_at'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
        if($this -> isNew())
        {
            $this -> widgetSchema['email']    = new sfWidgetFormInput();

            $this -> validatorSchema['email'] = new sfValidatorEmail();
        }


        if (!$this->isNew())
        {
            $sfUser = $this -> getObject() -> getSfUser();
            $sfUserForm = new SftUserNameForm($sfUser);
            $this -> embedForm('Identificación', $sfUserForm);

            $sftUser = $this->getObject()->dameSftUsuario();
            $sftUserForm = new SftUsuariosConActivoAliasCulturaForm($sftUser);
            $this->embedForm('usuario', $sftUserForm);

        }
        
    }


    public function save($con = null)
    {
        $object = parent::save($con);

        if($this -> isNew())
        {
            $email = new SftEmail();
            $email -> setDireccion($this -> getValue('email'));
            $email -> setIdUsuario($this -> getObject()->dameSftUsuario() -> getId());
            $email -> setPredeterminado(1);
            $email -> save();            
        }

        return $object;
    }
}
