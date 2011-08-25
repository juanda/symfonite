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

class edaGuardSecurityUser extends sfGuardSecurityUser
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
         * añadiremos las  variables de sesión propias de EDAE3
        */

        // Antes de nada, comprobamos que la aplicación está registrada
        // Es una comprobación de tipo paranoide, ya que se ha realizado
        // anteriormente en el momento de presentar el formulario de login
        $clave = sfConfig::get('app_clave');

        $in  = array('clave' => $clave);
        $serv = Servicio::crearServicioAplicaciones(sfConfig::get('app_servicio'));
        $out = $serv -> autorizacion($in);
        if($out['status'] != Servicio::ACCEPTED) //la aplicación no está autorizada

        {
            $mensaje = 'Aplicación no autorizada - Error '.$out['status'].' - '.Servicio::mensajeError($out['status']);
            sfContext::getInstance() -> getController() -> redirect('edaGestorErrores/mensajeError?mensaje='.$mensaje);
        }
        else
        {
            // comprobamos si es un usario de EDAE3;
            // observa que $user es un sfGuardUser
            $in = array();
            $in = array('id' => $user -> getUsername(), 'tipoId' => 'username');
            $serv = Servicio::crearServicioUsuario(sfConfig::get('app_servicio'));
            $out = $serv -> usuario($in);

            if($out['status'] == Servicio::OK)
            {

                // El usuario está activo

                $usuario   = $out['usuario'];

                // Comprobamos si el password ha expirado:

                if(sfConfig::get('app_password_expire', 0) > 0)
                {
                    if(Utilidades::getNumDaysInBetween($usuario['identificacion']['fecha_alta'], date('Y-m-d')) >= sfConfig::get('app_password_expire'))
                    {
                        $this -> signOut(); // Para que no pueda entrar en el sistema
                        $this -> setAttribute('id_sfuser', $usuario['identificacion']['sfId'], 'cambioPassword');
                        sfContext::getInstance()
                                -> getController()
                                -> redirect('edaGestorSesion/cambiarPassword');
                    }
                }


                $idUsuario = $usuario['identificacion']['edaId'];
                $this -> setAttribute('idUsuario',$idUsuario , 'EDAE3User');
                $this -> setAttribute('username', $usuario['identificacion']['username'], 'EDAE3User');
                $this -> setCulture($usuario['cultura_pref']);

                $oConfPersonal = new edaConfPersonal($idUsuario);
                $credencial_acceso =$this -> dameCredencialDeAcceso();
                if($oConfPersonal -> esValida())
                {
                    $this -> construyeSesion($oConfPersonal);

                    sfConfig::set('app_sf_guard_plugin_success_signin_url', '@homepage');
                }
                elseif($credencial_acceso)
                {
                    $this -> addCredential($credencial_acceso);
                    sfConfig::set('app_sf_guard_plugin_success_signin_url', '@mostrarperfiles');
                }
                else
                {
                    $this -> signOut();
                    $mensaje = 'Usuario sin perfiles en la aplicación';
                    $this -> setFlash('mensaje',$mensaje);
                }
            }
            else
            {
                $this -> signOut();
                $mensaje = 'Usuario no registrado en EDAE3';
                $this -> setFlash('mensaje',$mensaje);
            }
        }
    }

    public function signOut()
    {
        $this->getAttributeHolder()->removeNamespace('sfGuardSecurityUser');
        $this->getAttributeHolder()->removeNamespace('EDAE3User');
        $this->user = null;
        $this->clearCredentials();
        $this->setAuthenticated(false);
        $expiration_age = sfConfig::get('app_sf_guard_plugin_remember_key_expiration_age', 15 * 24 * 3600);
        $remember_cookie = sfConfig::get('app_sf_guard_plugin_remember_cookie_name', 'sfRemember');
        sfContext::getInstance()->getResponse()->setCookie($remember_cookie, '', time() - $expiration_age);
    }

    protected function tienePerfilesEnAplicacion()
    {
        $user = $this -> getGuardUser();
        $clave = sfConfig::get('app_clave');
        $in = array('id' => $user -> getUsername(), 'tipoId' => 'username', 'clave_aplicacion' => $clave);
        $serv = Servicio::crearServicioUsuario(sfConfig::get('app_servicio'));
        $out = $serv -> perfilesDelUsuarioEnAplicacion($in);

        if(count($out['perfiles']) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    protected  function dameCredencialDeAcceso()
    {
        $user = $this -> getGuardUser();
        $clave = sfConfig::get('app_clave');
        $in = array('id' => $user -> getUsername(), 'tipoId' => 'username', 'clave_aplicacion' => $clave);
        $serv = Servicio::crearServicioUsuario(sfConfig::get('app_servicio'));
        $out = $serv -> credencialesDelUsuarioEnAplicacion($in);

        $credenciales_usuario = (isset($out['credenciales']))? $out['credenciales'] : null;

        $in = array('clave' => $clave);
        $serv = Servicio::crearServicioAplicaciones(sfConfig::get('app_servicio'));
        $out  = $serv -> credenciales($in);

        $credencial_de_acceso = $out['credencial_de_acceso']['nombre'];

        $tiene_credencial_de_acceso = false;
        if(!is_null($credenciales_usuario))
        {
            foreach ($credenciales_usuario as $c)
            {
                if($c['nombre'] == $credencial_de_acceso)
                {
                    $tiene_credencial_de_acceso = true;
                }
            }
        }

        if($tiene_credencial_de_acceso)
        {
            return $credencial_de_acceso;
        }
        else
        {
            return false;
        }
    }
    /**
     * Esta función construye la sesión de usuario de EDAE3 que utilizarán la
     * aplicaciones que usen el plugin EDAE3 para el registro de sus usuarios
     *
     * @param ConfPersonal $oConfPersonal
     */
    public function construyeSesion($oConfPersonal)
    {

        // Unidad organizativa
        $this -> setAttribute('idUnidadOrganizativa', $oConfPersonal -> dameIdUnidadOrganizativa(), 'EDAE3User');

        // Ámbito
        $this -> setAttribute('idAmbito', $oConfPersonal -> dameIdAmbito(), 'EDAE3User');

        // Perfil
        $this -> setAttribute('idPerfil', $oConfPersonal -> dameIdPerfil(), 'EDAE3User');

        // Periodo
        $this -> setAttribute('idPeriodo', $oConfPersonal -> dameIdPeriodo(),'EDAE3User');

        // Marca
        $this -> setAttribute('marca', $oConfPersonal -> dameMarca(), 'EDAE3User');

        // Cargar credenciales
        $this -> cargaCredenciales();

        // Actualizar datos sobre acceso
        $this -> actualizaDatosDeAcceso();
    }

    /**
     *  Carga en la sesión de usuario de symfony las credenciales del perfil que
     *  accede a la aplicación.
     */
    protected function cargaCredenciales()
    {
        if($this -> getAttribute('idPerfil',null,'EDAE3User') != '')
        {
            $in = array('id' => $this -> getAttribute('idPerfil',null,'EDAE3User'));
            $serv = Servicio::crearServicioEstructuraOrganizativa(sfConfig::get('app_servicio'));
            $out = $serv -> perfil($in);

            if($out['status'] != Servicio::OK)
            {
                $mensaje = 'Error '.$out['status'].' - '.Servicio::mensajeError($out['status']);
                sfContext::getInstance() -> getController() -> redirect('edaGestorErrores/mensajeError?mensaje='.$mensaje);
            }

            $perfil = $out['perfil'];

            if(isset($perfil['credenciales']))
            {
                $credenciales = $perfil['credenciales'];
                foreach ($credenciales as $c)
                {
                    $this -> addCredential($c['credencial']['nombre']);
                }
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
        $controlAcceso =  EdaControlAccesosPeer::retrieveByPk($this -> getEdaUsuario() -> getId());

        if($controlAcceso instanceof EdaControlAccesos)
        {
            $controlAcceso -> setUpdatedAt(date('Y-m-d H:i:s'));
            $controlAcceso -> save();
        }

        $c = new Criteria();
        $c -> add(EdaEstadisticasAplicacionPeer::ID_USUARIO,$this -> getEdaUsuario() -> getId() );
        $c -> add(EdaAplicacionesPeer::CLAVE, sfConfig::get('app_clave'));
        $c -> addJoin(EdaEstadisticasAplicacionPeer::ID_APLICACION, EdaAplicacionesPeer::ID );

        $estadisticaAplicacion = EdaEstadisticasAplicacionPeer::doSelectOne($c);


        if(! ($estadisticaAplicacion instanceof EdaEstadisticasAplicacion))
        {
            $c = new Criteria();
            $c -> add(EdaAplicacionesPeer::CLAVE, sfConfig::get('app_clave'));
            $aplicacion = EdaAplicacionesPeer::doSelectOne($c);

            $estadisticaAplicacion = new EdaEstadisticasAplicacion();
            $estadisticaAplicacion -> setIdAplicacion($aplicacion -> getId());
            $estadisticaAplicacion -> setIdUsuario($this -> getEdaUsuario() -> getId());
        }

        $estadisticaAplicacion -> setNumeroAccesos($estadisticaAplicacion -> getNumeroAccesos() +1);
        $estadisticaAplicacion -> setNavegador($_SERVER['HTTP_USER_AGENT']);
        $estadisticaAplicacion -> setIpCliente($_SERVER['REMOTE_ADDR']);

        $estadisticaAplicacion -> save();

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
        $this -> setAttribute('idUnidadOrganizativa', '', 'EDAE3User');

        // Ámbito
        $this -> setAttribute('idAmbito', '', 'EDAE3User');

        // Perfil
        $this -> setAttribute('idPerfil', '', 'EDAE3User');

        // Ejercicio Académico
        $this -> setAttribute('idPeriodo', '', 'EDAE3User');

        // Marca
        $this -> setAttribute('marca', '', 'EDAE3User');

        // Credenciales
        $this -> clearCredentials();
    }

    public function getEdaUsuario()
    {
        $id = $this->getAttribute('idUsuario', null, 'EDAE3User');

        $this->user =  EdaUsuariosPeer::retrieveByPk($id);

        if (!$this->user)
        {
            // the user does not exist anymore in the database
            $this->signOut();

            throw new sfException('The user does not exist anymore in the database.');
        }
        
        return $this->user;
    }

    public function getEdaPerfil()
    {
        if (!$this->perfil && $id = $this->getAttribute('idPerfil', null, 'EDAE3User'))
        {
            $this->perfil = EdaPerfilesPeer::retrieveByPk($id);

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
        $sfPermission  = parent::hasPermission($name);
        $edaPermission = $this->getEdaPerfil() ? $this->getEdaPerfil()->hasPermission($name) : false;

        return ($sfPermiso || $edaPermiso);
    }

    public function getPermissions()
    {
        $sfPermission  = parent::getPermissions();
        $perfil = $this -> getEdaPerfil();
        $edaPermission = array();
        if($perfil instanceof EdaPerfiles)
        {
            $edaPermission = $perfil->getEdaCredenciales();
        }

        return array_merge($sfPermission, $edaPermission);
    }

    public function getPermissionNames()
    {
        $sfPermission  = parent::getPermissionNames();

        $perfil = $this -> getEdaPerfil();
        $edaPermission = array();
        if($perfil instanceof EdaPerfiles)
        {
            $edaPermission = $perfil->getPermissionNames();
        }

        return array_merge($sfPermission, $edaPermission);
    }

    public function getAllPermissions()
    {
        return $this -> getPermissions();
    }

    public function getAllPermissionNames()
    {
        return $this -> getPermissionNames();
    }

}
