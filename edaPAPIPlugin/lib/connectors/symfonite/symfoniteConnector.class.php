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
 * If you need the PAPI Request Parameters you can access them like this:
 *
 * $papiParams = sfContext::getInstance() -> getUser()->getAttributeHolder()
 * ->getNames('PAPIREQUEST')
 */

class symfoniteConnector
{
    protected $isAuthenticated = false;
    protected $signinData;
    protected $sfGuardUser;

    public function __construct($data)
    {
        $this->signinData = $data;

        if (isset($this->signinData['username']) && isset($this->signinData['password']))
        {
            $username = $this->signinData['username'];
            $password = $this->signinData['password'];

            if ($user = sfGuardUserPeer::retrieveByUsername($username))
            {
                if ($user->checkPassword($password))
                {
                    $this->isAuthenticated = true;
                    $this->sfGuardUser = $user;
                }
            }
        }
    }

    public function isAuthenticated()
    {
        return $this->isAuthenticated;
    }

    public function getAttributes()
    {
        if (!$this->sfGuardUser instanceof sfGuardUser)
        {
            return null;
        }

        $attributes = array();

        // add uid attribute
        $attributes['uid'] = $this -> sfGuardUser -> getUsername();

        // permission given to the user through the sfGuardPlugin
        $permissions = $this->sfGuardUser->getAllPermissions();
        // Add permission        
        foreach ($permissions as $permission)
        {
            $attributes['ePA'][] = $permission->getName();
        }

        // permission given to the user through the edaGuardPlugin
        $c = new Criteria();
        $c->add(EdaUsuariosPeer::ID_SFUSER, $this -> sfGuardUser -> getId());

        $edaUser = EdaUsuariosPeer::doSelectOne($c);
        if ($edaUser instanceof EdaUsuarios)
        {
            $attributes['cn'] = $edaUser->getNombre();
            $attributes['sn'] = $edaUser->getApellido1() . ' ' . $edaUser->getApellido2();

            // Credentials in all registrered applications
            $credenciales = $edaUser->getCredenciales();
            foreach ($credenciales as $credencial)
            {
                $attributes['ePA'][] = $credencial -> getNombre();
            }

            // Other Attributes
            $atributos = $edaUser->getEdaUsuAtributosValoress();
            foreach ($atributos as $atributo)
            {
                $attributes[$atributo->getEdaUsuAtributos()->getNombre()] =
                        $atributo ->getValor();
            }
        }

        return $attributes;
    }
}
