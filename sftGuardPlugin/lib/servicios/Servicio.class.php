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

class Servicio
{
    /**
     * Servicio.class.php
     *
     * Definicion de la clase base Servicio que implementa
     * las funciones comunes a todos los Servicio derivados
     * así como las constantes que representan los códigos de
     * error.
     *
     * Para la salida se han utilizado los códigos de estado del protocolo HTTP.
     *
     *
     * Los Servicio derivados de esta clase implementan funciones
     * que responden al mismo tipo de interfaz. El argumento de entrada es
     * un array asociativo con los parámetros que requiere el servicio para funcionar,
     * y el valor devuelto es otro array asociativo con los datos solicitados. Además
     * este array de salida siempre lleva un elemento denominado status con el estado
     * de salida (codigos de estado HTTP)
     *
     * Ejemplo de uso de un servicio
     *
     * <code>
     * $in = array('id' => 'anselmo', 'tipoId' => 'username');
     *
     * $servicio =
     * $out = ServicioUsuarios::usuario($in);
     *
     * if($out['status'] != Servicio::OK)
     * {
     *     echo Servicio::mensajeError($out['status']);
     *     exit;
     * }
     *
     * //Código que manipule $out
     *
     *</code>
     *
     *
     * @fecha 06-04-2010
     * @version 1.0.0
     *
     * @package Servicio
     *
     */

    // Successful
    const OK             = 200;
    const CREATED        = 201;
    const ACCEPTED       = 202;
    const NO_CONTENT     = 204;

    // Client Error
    const BAD_REQUEST    = 400;
    const UNAUTHORIZED   = 401;
    const NOT_FOUND      = 404;
    const NOT_ACCEPTABLE = 406 ;

    // Server Error
    const INTERNAL_SERVER_ERROR = 500;
    const NOT_IMPLEMENTED       = 501;

    /**
     * Devuelve un texto con el mensaje de error correspondiente
     * al código de error que se pasa como argumento
     *
     * @param Integer $codigo
     * @return String $mensaje
     */
    public static function mensajeError($codigo)
    {
        switch ($codigo)
        {
            case Servicio::OK:
                return 'Ok';
            case Servicio::ACCEPTED:
                return 'Petición Aceptada';
            case Servicio::NO_CONTENT:
                return 'Sin Contenido';
            case Servicio::BAD_REQUEST:
                return 'Petición erronea';
            case Servicio::NOT_ACCEPTABLE:
                return 'Petición no aceptable';
            case Servicio::NOT_FOUND:
                return 'Recurso no encontrado';
            case Servicio::UNAUTHORIZED:
                return 'No autorizado';
            case Servicio::INTERNAL_SERVER_ERROR:
                return 'Error interno del servicio';
            case Servicio::NOT_IMPLEMENTED;
                return 'Servicio no implementado';

        }
    }

    ///////////////////////////////
    ///////// FACTORIES////////////
    ///////////////////////////////
    public static function crearServicioUsuario($tipo=null)
    {
        switch ($tipo)
        {
            case 'CVE':
                return new ServicioUsuariosCVE();
                break;
            default:
                return new ServicioUsuariosEDAE();
                break;
        }
    }

    public static function crearServicioAplicaciones($tipo=null)
    {
        switch ($tipo)
        {
            case 'CVE':
                return new ServicioAplicacionesCVE();
                break;
            default:
                return new ServicioAplicacionesEDAE();
                break;
        }
    }

    public static function crearServicioEstructuraOrganizativa($tipo=null)
    {
        switch ($tipo)
        {
            case 'CVE':
                return new ServicioEstructuraOrganizativaCVE();
                break;
            default:
                return new ServicioEstructuraOrganizativaEDAE();
                break;
        }
    }
    // FIN FACTORIES //

    /**
     *  Devuelve un objeto de propel de tipo SftUsuario
     *  Utiliza la interfaz uniforme de entrada
     *
     * @param array $in
     *               |- id
     *               `- tipoId
     *
     * @return SftUsuario $edaUsuario
     */
    protected static function dameEdaUsuario($in)
    {
        ///////////////////////////////////////////
        // comprobación de la interfaz de entrada//
        ///////////////////////////////////////////
        if(!isset($in['id']) || !isset($in['tipoId']))
        {
            $out['status'] = Servicio::BAD_REQUEST;
            return $out;
        }
        ///////////////////////////////////////////

        $out = array();
        $c = new Criteria();

        switch ($in['tipoId'])
        {
            case 'username':
                $c -> add(sfGuardUserPeer::USERNAME, $in['id']);
                $c -> addJoin(SftUsuarioPeer::ID_SFUSER, sfGuardUserPeer::ID);
                break;

            case 'alias':
                $c -> add(SftUsuarioPeer::ALIAS, $in['id']);
                break;

            case 'edaId':
                $c -> add(SftUsuarioPeer::ID, $in['id']);
                break;

            default:
                $out['status'] = Servicio::NOT_ACCEPTABLE;
                break;
        }

        $edaUsuario = SftUsuarioPeer::doSelectOne($c);
        return $edaUsuario;
    }

    protected static function dameCVEUsuario($in)
    {
        ///////////////////////////////////////////
        // comprobación de la interfaz de entrada//
        ///////////////////////////////////////////
        if(!isset($in['id']) || !isset($in['tipoId']))
        {
            $out['status'] = Servicio::BAD_REQUEST;
            return $out;
        }
        ///////////////////////////////////////////

        $out = array();
        $c = new Criteria();

        switch ($in['tipoId'])
        {
            case 'username':
                $c -> add(sfGuardUserPeer::USERNAME, $in['id']);
                $sfUser = sfGuardUserPeer::doSelectOne($c);
                if(!($sfUser instanceof sfGuardUser))
                {
                    $out['status'] = Servicio::NOT_FOUND;
                    return $out;
                }                
                $c -> clear();
                $c -> add(PersonasPeer::ID_SFUSER, $sfUser -> getId());
                break;

            case 'edaId':
                $c -> add(PersonasPeer::ID, $in['id']);
                break;

            default:
                $out['status'] = Servicio::NOT_ACCEPTABLE;
                break;
        }

        $cveUsuario = PersonasPeer::doSelectOne($c);
        return $cveUsuario;
    }

}


