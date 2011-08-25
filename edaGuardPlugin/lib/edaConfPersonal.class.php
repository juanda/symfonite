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
class edaConfPersonal
{
    /**
     * @var integer $eIdUsuario
     */
    protected $eIdUsuario;

    /**
     * @var integer $eUnidadOrganizativa
     */
    protected $eIdUnidadOrganizativa;

    /**
     * @var integer $eIdAmbito
     */
    protected $eIdAmbito;

    /**
     * @var integer $eIdPerfil
     */
    protected $eIdPerfil;


    /**
     * @var integer $eIdPeriodo
     */
    protected $eIdPeriodo;

    /**
     * @var integer $aMarca
     */
    protected $aMarca;

    /**
     * @var string $aCultura
     */
    protected $aCultura;

    /**
     * Indica si la configuracion personal es válida o no
     *
     * @var boolean
     */
    protected $bValida;

    /**
     *Constructor
     *
     * @param integer $eIdUsuario
     * @param string  $tipo
     */
    public function __construct($eIdUsuario, $eIdPerfil=null, $eIdAmbito=null, $eIdPeriodo=null)
    {
        $this -> eIdUsuario   = $eIdUsuario;
        $this -> construyeConfPersonal($eIdPerfil, $eIdAmbito, $eIdPeriodo);
    }

    /**
     * Aquí se construye un vector con una configuración personal válida (si es posible).
     *
     *  Aún no está implementado. Por lo pronto devuelve una sesión nula y por tanto no válida.
     *
     * @param string $tipo
     */
    protected function construyeConfPersonal($eIdPerfil=null, $eIdAmbito=null, $eIdPeriodo=null)
    {
        if(is_null($eIdPerfil) && is_null($eIdAmbito) && is_null($eIdPeriodo) )
        {
            //Este es el caso en el que el usuario ha hecho login
            $this->buscarConfiguracionEnBaseDatos();
        }
        else
        {
            //Este es el caso en el que el usuario cambia de perfil
            //El usuario nos manda el perfil, ambito y EA al que quiere cambiarse
            //Hay que comprobar que dicho usuario tenga permiso para cambiarse a dicho perfil (para
            //evitar usos malintencionados o errores en el listado de perfiles disponibles para el usuario)

            $this->comprobarConfiguracionValida($eIdPerfil,$eIdAmbito,$eIdPeriodo);
        }

    }

    /**
     * Realiza las operaciones sobre la sesión del usuario cuando se produce una conexión de usuario.
     *
     * Almacena la configuración personal del usuario (actualiza las variables de sesión idIdioma, idPersona, idUsuario) y llamamos a la funcion miembro "asignarPerfilUsuario"
     * para asociarle un perfil.
     *
     * @return object|oError Objeto de la clase Error (si se produce un error). Sino, devuelve False.
     */
    protected function buscarConfiguracionEnBaseDatos()
    {
        $c = new Criteria();
        $c -> add(EdaAplicacionesPeer::CLAVE, sfConfig::get('app_clave'));
        $c -> addJoin(EdaAplicacionesPeer::ID, EdaConfpersonalesPeer::ID_APLICACION);
        $c -> add(EdaConfpersonalesPeer::ID_USUARIO, $this -> dameIdUsuario());

        $confP = EdaConfpersonalesPeer::doSelectOne($c);


        if($confP instanceof EdaConfpersonales)
        {
            $eIdPerfil  = $confP -> getIdPerfil();
            $eIdAmbito  = $confP -> getIdAmbito();
            $eIdPeriodo = $confP -> getIdPeriodo();

            $this->comprobarConfiguracionValida($eIdPerfil,$eIdAmbito,$eIdPeriodo);
        }
        else
        {
            $this -> bValida = false;
        }
    }

    /**
     * Enter description here...
     *
     * @todo Por hacer
     *
     * @param integer $eIdPerfil
     * @param integer $eIdAmbito
     * @param integer $eIdPeriodo
     */
    protected function comprobarConfiguracionValida($eIdPerfil,$eIdAmbito,$eIdPeriodo)
    {
        // Asignamos el resto de parámetros que foman la configuración personal
        $this -> eIdPerfil = $eIdPerfil;
        $this -> eIdAmbito = $eIdAmbito;
        $this -> eIdPeriodo = $eIdPeriodo;

        ////////////////////////////////////////////////////////////////////////////
        //Comprobamos que el perfil tenga la credencial de acceso de la aplicacion//
        ////////////////////////////////////////////////////////////////////////////
        
        $clave = sfConfig::get('app_clave');

        $in  = array('clave' => $clave);
        $serv = Servicio::crearServicioAplicaciones(sfConfig::get('app_servicio'));
        $out = $serv -> credenciales($in);

        if($out['status'] != Servicio::OK) //la aplicación no está autorizada

        {
            $mensaje = 'Aplicación sin credenciales - Error '.$out['status'].' - '.Servicio::mensajeError($out['status']);
            sfContext::getInstance() -> getController() -> redirect('edaGestorErrores/mensajeError?mensaje='.$mensaje);
        }

        $credencial_de_acceso = $out['credencial_de_acceso']['nombre'];

        $in = array(
                'id'     => $eIdPerfil,
                'clave_aplicacion'  => $clave);

        $serv = Servicio::crearServicioEstructuraOrganizativa(sfConfig::get('app_servicio'));
        $out = $serv -> credencialesDelPerfilEnAplicacion($in);

        if($out['status'] != Servicio::OK) //la aplicación no está autorizada

        {
            $mensaje = 'Error en servicio usuario  - Error '.$out['status'].' - '.Servicio::mensajeError($out['status']);
            sfContext::getInstance() -> getController() -> redirect('edaGestorErrores/mensajeError?mensaje='.$mensaje);
        }

        $credenciales = (isset($out['credenciales']))? $out['credenciales'] : null;

        $tiene_credencial_de_acceso = false;
        if(isset ($out['credenciales']))
        {
            foreach ($credenciales as $c)
            {
                if($c['nombre'] == $credencial_de_acceso)
                {
                    $tiene_credencial_de_acceso = true;
                }
            }
        }
        if(!$tiene_credencial_de_acceso)
        {
            $this -> bValida = false;
            return;
        }

        ////////////////////////////////////////////////////
        // Comprobamos que el usuario tenga el perfil dado//
        ////////////////////////////////////////////////////

        $in = array(
            'id' => sfContext::getInstance() -> getUser() -> getUsername(),
            'tipoId' => 'username',
            'clave_aplicacion' => sfConfig::get('app_clave'));
        $serv = ServicioUsuarios::crearServicioUsuario(sfConfig::get('app_servicio'));
        $out = $serv -> perfilesDelUsuarioEnAplicacion($in);
        
        // Comprobamos que el usuario tenga algún perfil en la uo del periodo

        $c = new Criteria();
        $c -> add(EdaPeriodosPeer::ID, $eIdPeriodo);
        $c -> addJoin(EdaPeriodosPeer::ID_UO, EdaPerfilesPeer::ID_UO);

        $numPerfiles = EdaPerfilesPeer::doCount($c);

        if($numPerfiles == 0)
        {
            $this -> bValida = false;
            return;
        }

        // Comprobamos que el usuario tenga asignado ese perfil
        $c -> clear();
        $c -> add(EdaAccesosPeer::ID_PERFIL, $eIdPerfil);
        $c -> add(EdaAccesosPeer::ID_USUARIO, $this -> eIdUsuario);

        $numAccesos = EdaAccesosPeer::doCount($c);

        if($numAccesos == 0)
        {
            $this -> bValida = false;
            return;
        }

        // Comprobamos que el usuario tenga asignado ese Ambito
        //
        // Por implementar

        $this -> bValida = true;
    }

    // getters

    public function dameIdUsuario()
    {
        return $this -> eIdUsuario;
    }

    public function dameIdUnidadOrganizativa()
    {
        if(is_null($this-> eIdUnidadOrganizativa) || $this -> eIdUnidadOrganizativa = '')
        {
            $perfil = EdaPerfilesPeer::retrieveByPK($this -> eIdPerfil);

            $this -> eIdUnidadOrganizativa = $perfil -> getEdaUos() -> getId();
        }

        return $this -> eIdUnidadOrganizativa;
    }

    public function dameIdAmbito()
    {
        return $this -> eIdAmbito;
    }

    public function dameIdPerfil()
    {
        return $this -> eIdPerfil;
    }

    public function dameIdPeriodo()
    {
        return $this -> eIdPeriodo;
    }

    public function dameCultura()
    {
        if(is_null($this ->aCultura) || $this ->aCultura =='')
        {
            $usuario = EdaUsuariosPeer::retrieveByPK($this -> eIdPerfil);
            $this  -> aCultura = $usuario -> getIdCulturapref();
        }
        return $this -> aCultura;
    }

    public function dameMarca()
    {
        if(is_null($this -> aMarca) || $this -> aMarca == '')
        {
            $perfil = EdaPerfilesPeer::retrieveByPK($this -> eIdPerfil);

            $this -> aMarca = $perfil -> getEdaUos() -> getMarca();
        }
        return $this -> aMarca;
    }

    public function esValida()
    {
        return $this -> bValida;
    }
}