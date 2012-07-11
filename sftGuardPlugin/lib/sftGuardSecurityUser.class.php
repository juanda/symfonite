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

class sftGuardSecurityUser extends sfGuardSecurityUser
{

    protected $perfil = null;

    public function signIn($user, $remember = false, $con = null)
    {
        parent::signIn($user, $remember, $con);
        /* En este punto el usuario ya está autentificado y
         * tiene las credenciales que le corresponde a través
         * de los grupos del plugin sfGuardPlugin.
         * Además en la sesión hay una variable llamada user_id
         * en un AttributeHolder llamado 'sfGuardSecurityUser'.
         * Mantendremos a este otro para que otros plugins que
         * hagan uso del sfGuardPlugin puedan utilizarse. Ahora
         * añadiremos las  variables de sesión propias de symfonite
         */

        // Antes de nada, comprobamos que la aplicación está registrada
        // Es una comprobación de tipo paranoide, ya que se ha realizado
        // anteriormente en el momento de presentar el formulario de login
        sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');

        $clave = sfConfig::get('app_clave');


        $oAplicacion = SftAplicacionPeer::dameAplicacionConClave($clave);
        
        if (!$oAplicacion instanceof SftAplicacion/* $out['status'] != Servicio::ACCEPTED */) //la aplicación no está autorizada
        {
            $mensaje = __('Aplicación no autorizada');
            sfContext::getInstance()->getController()->redirect('@sftGuardPlugin_mensajeError?mensaje=' . $mensaje);
        } else
        {
            // comprobamos si es un usario de symfonite;
            // observa que $user es un sfGuardUser
            $c = new Criteria();
            $c->add(SftUsuarioPeer::ID_SFUSER, $user->getId());
            $sftUsuario = SftUsuarioPeer::doSelectOne($c);

            if ($sftUsuario instanceof sftUsuario)
            {
                if (!$sftUsuario->getActivo())
                {
                    $mensaje = __('Usuario inactivo');
                    sfContext::getInstance()
                            ->getController()
                            ->redirect('@sftGuardPlugin_mensajeError?mensaje=' . $mensaje);
                }

                // El usuario está activo
                // Comprobamos si el password ha expirado:

                if (sfConfig::get('app_password_expire', 0) > 0)
                {

                    if (Utilidades::getNumDaysInBetween($sftUsuario->getUpdatedAt('Y-m-d'), date('Y-m-d')) >= sfConfig::get('app_password_expire'))
                    {
                        $this->signOut(); // Para que no pueda entrar en el sistema
                        $this->setAttribute('id_sfuser', $sftUsuario->getSfGuardUser()->getId(), 'cambioPassword');
                        sfContext::getInstance()
                                ->getController()
                                ->redirect('@sftGuardPlugin_cambiarPassword');
                    }
                }

                $idUsuario = $sftUsuario->getId();
                $this->setAttribute('idUsuario', $idUsuario, 'SftUser');
                $this->setAttribute('username', $sftUsuario->getUsername(), 'SftUser');
                $this->setCulture($sftUsuario->getIdCulturapref());

                $oConfPersonal = new sftConfiguracionPersonal($idUsuario);
                $credencial_acceso = $oAplicacion->getSftCredencial();
                if ($oConfPersonal->esValida())
                {
                    $this->construyeSesion($oConfPersonal);

                    sfConfig::set('app_sf_guard_plugin_success_signin_url', '@homepage');
                } elseif ($credencial_acceso)
                {
                    $this->addCredential($credencial_acceso);
                    sfConfig::set('app_sf_guard_plugin_success_signin_url', '@sftGuardPlugin_mostrarperfiles');
                } else
                {
                    $this->signOut();
                    $mensaje = __('Usuario sin perfiles en la aplicación');
                    $this->setFlash('mensaje', $mensaje);
                }
            } else
            {
                $this->signOut();
                $mensaje = __('Usuario no registrado en el sistema');
                $this->setFlash('mensaje', $mensaje);
            }
        }
    }

    public function signOut()
    {
        $app_yml = sfYaml::load(sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR .
                        'sftGuardPlugin' . DIRECTORY_SEPARATOR . 'config/app.yml');

        $variables_sesion = $app_yml['all']['variables_sesion'];
        foreach($variables_sesion as $variable_sesion){
            $this->getAttributeHolder()->removeNamespace("$variable_sesion");
        }
        $this->user = null;
        $this->clearCredentials();
        $this->setAuthenticated(false);
        $expiration_age = sfConfig::get('app_sf_guard_plugin_remember_key_expiration_age', 15 * 24 * 3600);
        $remember_cookie = sfConfig::get('app_sf_guard_plugin_remember_cookie_name', 'sfRemember');
        sfContext::getInstance()->getResponse()->setCookie($remember_cookie, '', time() - $expiration_age);
    }

    protected function tienePerfilesEnAplicacion()
    {
        $usuario = $this->getSftUsuario();
        $clave = sfConfig::get('app_clave');
        $aplicacion = SftAplicacionPeer::dameAplicacionConClave($clave);

        $perfiles = $usuario->getPerfilesEnAplicacion($aplicacion->getId());
        if (count($out['perfiles']) > 0)
        {
            return true;
        } else
        {
            return false;
        }
    }

    protected function dameCredencialDeAcceso()
    {
        $user = $this->getSftUsuario();
        $clave = sfConfig::get('app_clave');
        $aplicacion = SftAplicacionPeer::dameAplicacionConClave($clave);

        $credenciales = $usuario->getCredenciales($aplicacion->getId());

        $credencial_de_acceso = $aplicacion->getSftCredencial();

        $tiene_credencial_de_acceso = false;
        if (!is_null($credenciales_usuario))
        {
            foreach ($credenciales_usuario as $c)
            {
                if ($c['nombre'] == $credencial_de_acceso)
                {
                    $tiene_credencial_de_acceso = true;
                }
            }
        }

        if ($tiene_credencial_de_acceso)
        {
            return $credencial_de_acceso;
        } else
        {
            return false;
        }
    }

    /**
     * Esta función construye la sesión de usuario de symfonite que utilizarán la
     * aplicaciones que usen el plugin sft para el registro de sus usuarios
     *
     * @param ConfPersonal $oConfPersonal
     */
    public function construyeSesion($oConfPersonal)
    {

        // Unidad organizativa
        $this->setAttribute('idUnidadOrganizativa', $oConfPersonal->dameIdUnidadOrganizativa(), 'SftUser');

        // Ámbito
        $this->setAttribute('idAmbito', $oConfPersonal->dameIdAmbito(), 'SftUser');

        // Perfil
        $this->setAttribute('idPerfil', $oConfPersonal->dameIdPerfil(), 'SftUser');

        // Periodo
        $this->setAttribute('idPeriodo', $oConfPersonal->dameIdPeriodo(), 'SftUser');
        
        // Cargar credenciales
        $this->cargaCredenciales();
        
        // Actualizar datos sobre acceso
        $this->actualizaDatosDeAcceso();
    }

    /**
     *  Carga en la sesión de usuario de symfony las credenciales del perfil que
     *  accede a la aplicación.
     */
    protected function cargaCredenciales()
    {
        if ($this->getAttribute('idPerfil', null, 'SftUser') != '')
        {
            $idPerfil = $this->getAttribute('idPerfil', null, 'SftUser');
            $perfil = SftPerfilPeer::retrieveByPK($idPerfil);

            if (!$perfil instanceof SftPerfil)
            {
                throw new Exception('Perfil inexistente');
            }

            $credenciales = $perfil->getSftCredenciales();
            
            foreach ($credenciales as $c)
            {
                $this->addCredential($c->getNombre());
            }
        }
    }

    /**
     *  Actualiza los datos sobre el acceso del usuario al sistema symfonite:
     *
     *  - último acceso
     *  - caducidad
     *  - bloqueo
     *  - causa bloqueo
     *  - ...
     */
    public function actualizaDatosDeAcceso()
    {
        $controlAcceso = SftControlAccesoPeer::retrieveByPk($this->getSftUsuario()->getId());

        if ($controlAcceso instanceof SftControlAcceso)
        {
            $controlAcceso->setUpdatedAt(date('Y-m-d H:i:s'));
            $controlAcceso->save();
        }

        $c = new Criteria();
        $c->add(SftEstadisticaAplicacionPeer::ID_USUARIO, $this->getSftUsuario()->getId());
        $c->add(SftAplicacionPeer::CLAVE, sfConfig::get('app_clave'));
        $c->addJoin(SftEstadisticaAplicacionPeer::ID_APLICACION, SftAplicacionPeer::ID);

        $estadisticaAplicacion = SftEstadisticaAplicacionPeer::doSelectOne($c);


        if (!($estadisticaAplicacion instanceof SftEstadisticaAplicacion))
        {
            $c = new Criteria();
            $c->add(SftAplicacionPeer::CLAVE, sfConfig::get('app_clave'));
            $aplicacion = SftAplicacionPeer::doSelectOne($c);

            $estadisticaAplicacion = new SftEstadisticaAplicacion();
            $estadisticaAplicacion->setIdAplicacion($aplicacion->getId());
            $estadisticaAplicacion->setIdUsuario($this->getSftUsuario()->getId());
        }

        $estadisticaAplicacion->setNumeroAccesos($estadisticaAplicacion->getNumeroAccesos() + 1);
        $estadisticaAplicacion->setNavegador($_SERVER['HTTP_USER_AGENT']);
        $estadisticaAplicacion->setIpCliente($_SERVER['REMOTE_ADDR']);

        $estadisticaAplicacion->save();
    }

    /**
     * Borra las credenciales y los atributos de la sesion (a exepción del usuario
     * de la cultura)
     *
     * Esta función se utiliza en el cambio de perfil
     */
    public function resetSesion()
    {
        // La cultura y el usuario se dejan como están
        // Unidad organizativa
        $this->setAttribute('idUnidadOrganizativa', '', 'SftUser');

        // Ámbito
        $this->setAttribute('idAmbito', '', 'SftUser');

        // Perfil
        $this->setAttribute('idPerfil', '', 'SftUser');

        // Ejercicio Académico
        $this->setAttribute('idPeriodo', '', 'SftUser');

        // Marca
        $this->setAttribute('marca', '', 'SftUser');

        // Credenciales
        $this->clearCredentials();
    }

    public function getSftUsuario()
    {
        $id = $this->getAttribute('idUsuario', null, 'SftUser');

        $this->user = SftUsuarioPeer::retrieveByPk($id);

        if (!$this->user)
        {
            // the user does not exist anymore in the database
            $this->signOut();

            throw new sfException('The user does not exist anymore in the database.');
        }

        return $this->user;
    }

    public function getSftPerfil()
    {
        if (!$this->perfil && $id = $this->getAttribute('idPerfil', null, 'SftUser'))
        {
            $this->perfil = SftPerfilPeer::retrieveByPk($id);

            if (!$this->perfil)
            {
                // the user does not exist anymore in the database
                $this->signOut();

                throw new sfException('The perfil does not exist anymore in the database.');
            }
        }

        return $this->perfil;
    }

    public function hasPermission($name)
    {
        $sfPermission = parent::hasPermission($name);
        $sftPermission = $this->getSftPerfil() ? $this->getSftPerfil()->hasPermission($name) : false;

        return ($sfPermission || $sftPermission);
    }

    public function getPermissions()
    {
        $sfPermission = parent::getPermissions();
        $perfil = $this->getSftPerfil();
        $sftPermission = array();
        if ($perfil instanceof SftPerfil)
        {
            $sftPermission = $perfil->getSftCredenciales();
        }

        return array_merge($sfPermission, $sftPermission);
    }

    public function getPermissionNames()
    {
        $sfPermission = parent::getPermissionNames();

        $perfil = $this->getSftPerfil();
        $sftPermission = array();
        if ($perfil instanceof SftPerfil)
        {
            $sftPermission = $perfil->getPermissionNames();
        }

        return array_merge($sfPermission, $sftPermission);
    }

    public function getAllPermissions()
    {
        return $this->getPermissions();
    }

    public function getAllPermissionNames()
    {
        return $this->getPermissionNames();
    }

}
