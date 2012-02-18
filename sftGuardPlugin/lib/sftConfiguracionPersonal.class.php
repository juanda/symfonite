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

class sftConfiguracionPersonal
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
     * Constructor
     *
     * @param integer $eIdUsuario
     * @param string  $tipo
     */
    public function __construct($eIdUsuario, $eIdPerfil=null, $eIdAmbito=null, $eIdPeriodo=null)
    {
        $this->eIdUsuario = $eIdUsuario;
        $this->construyeConfiguracionPersonal($eIdPerfil, $eIdAmbito, $eIdPeriodo);
    }

    /**
     * Aquí se construye un vector con una configuración personal válida (si es posible).
     *
     *  Aún no está implementado. Por lo pronto devuelve una sesión nula y por tanto no válida.
     *
     * @param string $tipo
     */
    protected function construyeConfiguracionPersonal($eIdPerfil=null, $eIdAmbito=null, $eIdPeriodo=null)
    {
        if (is_null($eIdPerfil) && is_null($eIdAmbito) && is_null($eIdPeriodo))
        {
            //Este es el caso en el que el usuario ha hecho login
            $this->buscarConfiguracionEnBaseDatos();
        } else
        {
            //Este es el caso en el que el usuario cambia de perfil
            //El usuario nos manda el perfil, ambito y EA al que quiere cambiarse
            //Hay que comprobar que dicho usuario tenga permiso para cambiarse a dicho perfil (para
            //evitar usos malintencionados o errores en el listado de perfiles disponibles para el usuario)

            $this->comprobarConfiguracionValida($eIdPerfil, $eIdAmbito, $eIdPeriodo);
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
        $c->add(SftAplicacionPeer::CLAVE, sfConfig::get('app_clave'));
        $c->addJoin(SftAplicacionPeer::ID, SftConfPersonalPeer::ID_APLICACION);
        $c->add(SftConfPersonalPeer::ID_USUARIO, $this->dameIdUsuario());

        $confP = SftConfPersonalPeer::doSelectOne($c);


        if ($confP instanceof SftConfPersonal)
        {
            $eIdPerfil = $confP->getIdPerfil();
            $eIdAmbito = $confP->getIdAmbito();
            $eIdPeriodo = $confP->getIdPeriodo();

            $this->comprobarConfiguracionValida($eIdPerfil, $eIdAmbito, $eIdPeriodo);
        } else
        {
            $this->bValida = false;
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
    protected function comprobarConfiguracionValida($eIdPerfil, $eIdAmbito, $eIdPeriodo)
    {
        // Asignamos el resto de parámetros que foman la configuración personal
        $this->eIdPerfil = $eIdPerfil;
        $this->eIdAmbito = $eIdAmbito;
        $this->eIdPeriodo = $eIdPeriodo;

        ////////////////////////////////////////////////////////////////////////////
        //Comprobamos que el perfil tenga la credencial de acceso de la aplicacion//
        ////////////////////////////////////////////////////////////////////////////

        $clave = sfConfig::get('app_clave');

        $aplicacion = SftAplicacionPeer::dameAplicacionConClave($clave);

        $perfil = SftPerfilPeer::retrieveByPK($eIdPerfil);

        if (!$perfil instanceof SftPerfil)
        {
            throw new Exception('Perfil inexistente');
        }

        $tiene_credencial_accceso = $perfil->tieneCredencial($aplicacion->getSftCredencial()->getId());
        
        if (! $tiene_credencial_accceso)
        {
            $this->bValida = false;
            return;
        }

        //////////////////////////////////////////////////////////////
        // Comprobamos que en el periodo, y por tanto en la UO, este//
        // asociado ese perfil                                      //
        //////////////////////////////////////////////////////////////

        $c = new Criteria();
        $c->add(SftPeriodoPeer::ID, $eIdPeriodo);
        $c->addJoin(SftPeriodoPeer::ID_UO, SftPerfilPeer::ID_UO);
        $c->add(SftPerfilPeer::ID, $eIdPerfil);

        $numPerfiles = SftPerfilPeer::doCount($c);

        if ($numPerfiles == 0)
        {
            $this->bValida = false;
            return;
        }

        /////////////////////////////////////////////////////////
        // Comprobamos que el usuario tenga asignado ese perfil//
        /////////////////////////////////////////////////////////        
        $c->clear();
        $c->add(SftAccesoPeer::ID_PERFIL, $eIdPerfil);
        $c->add(SftAccesoPeer::ID_USUARIO, $this->eIdUsuario);

        $numAccesos = SftAccesoPeer::doCount($c);

        if ($numAccesos == 0)
        {
            $this->bValida = false;
            return;
        }

        // Comprobamos que el usuario tenga asignado ese Ambito
        //
        // Por implementar

        $this->bValida = true;
    }

    // getters

    public function dameIdUsuario()
    {
        return $this->eIdUsuario;
    }

    public function dameIdUnidadOrganizativa()
    {
        if (is_null($this->eIdUnidadOrganizativa) || $this->eIdUnidadOrganizativa = '')
        {
            $perfil = SftPerfilPeer::retrieveByPK($this->eIdPerfil);

            $this->eIdUnidadOrganizativa = $perfil->getSftUo()->getId();
        }

        return $this->eIdUnidadOrganizativa;
    }

    public function dameIdAmbito()
    {
        return $this->eIdAmbito;
    }

    public function dameIdPerfil()
    {
        return $this->eIdPerfil;
    }

    public function dameIdPeriodo()
    {
        return $this->eIdPeriodo;
    }

    public function dameCultura()
    {
        if (is_null($this->aCultura) || $this->aCultura == '')
        {
            $usuario = SftUsuarioPeer::retrieveByPK($this->eIdPerfil);
            $this->aCultura = $usuario->getIdCulturapref();
        }
        return $this->aCultura;
    }
    
    public function esValida()
    {
        return $this->bValida;
    }

}