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

class ServicioEstructuraOrganizativaEDAE extends ServicioEstructuraOrganizativa
{
    public function perfil($in)
    {
        ///////////////////////////////////////////
        // comprobación de la interfaz de entrada//
        ///////////////////////////////////////////
        if(!isset($in['id']))
        {
            $out['status'] = Servicio::BAD_REQUEST;
            return $out;
        }
        ///////////////////////////////////////////

        $edaPerfil = EdaPerfilesPeer::retrieveByPK($in['id']);

        if(! ($edaPerfil instanceof EdaPerfiles))
        {
            $out['status'] = Servicio::NOT_FOUND;
            return $out;
        }

        $perfil = array();

        $perfil['nombre']               = $edaPerfil -> getNombre();
        $perfil['descripcion']          = $edaPerfil -> getDescripcion();
        $perfil['abreviatura']          = $edaPerfil -> getAbreviatura();
        $perfil['menu']                 = $edaPerfil -> getMenu();
        $perfil['uo']['id']             = $edaPerfil -> getIdUo();
        $perfil['uo']['nombre']         = $edaPerfil -> getEdaUos() -> getNombre();
        $perfil['uo']['marca']          = $edaPerfil -> getEdaUos() -> getMarca();
        if($edaPerfil -> getEdaAmbitostipos() instanceof EdaAmbitostipos)
        {
            $perfil['ambitotipo']['id']     = $edaPerfil -> getEdaAmbitosTipos() -> getId();
            $perfil['ambitotipo']['nombre'] = $edaPerfil -> getEdaAmbitosTipos() -> getNombre();
        }

        // Credenciales
        $perfil_credenciales = $edaPerfil -> getEdaPerfilCredencials();
        $i = 0;
        foreach ($perfil_credenciales as $pc)
        {
            $perfil['credenciales'][$i]['credencial']['nombre']       = $pc -> getEdaCredenciales() -> getNombre();
            $perfil['credenciales'][$i]['credencial']['descripcion']  = $pc -> getEdaCredenciales() -> getDescripcion();
            $perfil['credenciales'][$i++]['credencial']['aplicacion'] = $pc -> getEdaCredenciales() -> getEdaAplicaciones() -> getCodigo();
        }

        $out['status'] = Servicio::OK;
        $out['perfil'] = $perfil;

        return $out;
    }

    /**
     * Devuelve informacion sobre las credenciales que tiene un perfil
     * en una aplicación identificada por su clave.
     *
     *  Los estados de salida pueden ser:
     * -> BAD_REQUEST si la interfaz uniforme de entrada no es válida
     * -> NOT_FOUND   si el usuario no existe
     * -> OK          si se han recuperdado los datos de un usuario
     *
     * @param array $in
     *               |- id
     *               `- clave_aplicacion
     * @return $out
     *          |-status
     *          |
     *          `-credenciales
     */
    public function credencialesDelPerfilEnAplicacion($in)
    {
        ///////////////////////////////////////////
        // comprobación de la interfaz de entrada//
        ///////////////////////////////////////////
        if(!isset($in['id']) || !isset($in['clave_aplicacion']))
        {
            $out['status'] = Servicio::BAD_REQUEST;
            return $out;
        }
        ///////////////////////////////////////////


        $c = new Criteria();

        $c -> add(EdaAplicacionesPeer::CLAVE, $in['clave_aplicacion']);
        $c -> addJoin(EdaAplicacionesPeer::ID, EdaCredencialesPeer::ID_APLICACION);
        $c -> addJoin(EdaCredencialesPeer::ID, EdaPerfilCredencialPeer::ID_CREDENCIAL);
        $c -> addJoin(EdaPerfilCredencialPeer::ID_PERFIL, $in['id']);

        $credenciales = EdaCredencialesPeer::doSelect($c);

        $out['status'] = Servicio::OK;

        $i=0;
        foreach($credenciales as $c)
        {
            $out['credenciales'][$i]['nombre']      = $c -> getNombre();
            $out['credenciales'][$i]['descripcion'] = $c -> getDescripcion();
            $i++;
        }

        return $out;
    }

    /**
     * Devuelve el nombre, la descripcion y el periodo al que pertenece
     * un ambito con un determinado id
     *
     * @param array $in
     *                `- id  el id del ambito en la tabla de ambito (esto no hay quien lo entienda)
     *
     * @return array $out
     *                |- status
     *                `- ambito
     *                   |- nombre
     *                   |- descripcion
     *                   |- fechaAlta
     *                   |- idPeriodo
     *                   `- idAmbitotipo
     */

    public function ambito($in)
    {
        ///////////////////////////////////////////
        // comprobación de la interfaz de entrada//
        ///////////////////////////////////////////
        if(!isset($in['id']))
        {
            $out['status'] = Servicio::BAD_REQUEST;
            return $out;
        }
        ///////////////////////////////////////////

        $edaAmbito = EdaAmbitosPeer::retrieveByPK($in['id']);

        if(!($edaAmbito instanceof EdaAmbitos))
        {
            $out['status'] = Servicio::NOT_FOUND;
            $out['ambito'] = 'no_ambitos';
            return $out;
        }

        $ambito['nombre']       = $edaAmbito -> getNombre();
        $ambito['descripcion']  = $edaAmbito -> getDescripcion();
        $ambito['estado']       = $edaAmbito -> getEstado();
        $ambito['idPeriodo']    = $edaAmbito -> getIdPeriodo();
        $ambito['idAmbitotipo'] = $edaAmbito -> getIdAmbitotipo();

        $out['status'] = Servicio::OK;
        $out['ambito'] = $ambito;

        return $out;
    }

    /**
     *
     * @param array $in
     *                `- id
     *
     * @return array $out
     *                |- status
     *                `- periodo
     *                   |- fecha_inicio
     *                   |- fecha_fin
     *                   |- descripcio
     *                   `- estado
     */
    public function periodo($in)
    {
        ///////////////////////////////////////////
        // comprobación de la interfaz de entrada//
        ///////////////////////////////////////////
        if(!isset($in['id']))
        {
            $out['status'] = Servicio::BAD_REQUEST;
            return $out;
        }
        ///////////////////////////////////////////

        $edaPeriodo = EdaPeriodosPeer::retrieveByPK($in['id']);

        if(!($edaPeriodo instanceof EdaPeriodos))
        {
            $out['status'] = Servicio::NOT_FOUND;
            return $out;
        }

        if(count($edaPeriodo -> getEdaUos() -> getEdaPeriodoss()) == 1)
        {
            $periodo['unico'] = true;
        }
        else
        {
            $periodo['unico'] = false;
        }

        $periodo['fecha_inicio'] = $edaPeriodo -> getFechainicio();
        $periodo['fecha_fin']    = $edaPeriodo -> getFechafin();
        $periodo['descripcion']  = $edaPeriodo -> getDescripcion();
        $periodo['estado']       = $edaPeriodo -> getEstado();

        $out['status']  = Servicio::OK;
        $out['periodo'] = $periodo;

        return $out;

    }

    protected function obtenerAmbitoPredeterminadoEnAplicacion($id_usuario, $eIdPerfil, $clave_aplicacion)
    {

        //A partir el id_acceso y del nombre de la clase propel de la tabla.
        return null;
    }

    protected function obtenerAmbitoPerfilEnAplicacion($id_usuario, $eIdPerfil, $clave_aplicacion)
    {
        //A partir el id_acceso y del nombre de la clase propel de la tabla.
        return null;
    }

    protected function obtenerPeriodoAmbito()
    {
        //A partir el id_acceso y del nombre de la clase propel de la tabla.
        return null;
    }

    protected function obtenerPeriodoActivo($eIdUO)
    {
        $c = new Criteria();
        $c -> add(EdaUosPeer::ID, $eIdUO);
        $c -> addJoin(EdaPeriodosPeer::ID_UO, EdaUosPeer::ID);
        $c -> add(EdaPeriodosPeer::ESTADO, 'ACTIVO');

        $periodo = EdaPeriodosPeer::doSelectOne($c);

        return $periodo -> getId();
    }

    protected function obtenerConfPersonasDeBaseDatos($id_usuario, $claveAplicacion)
    {
        $c = new Criteria();
        $c -> add(EdaAplicacionesPeer::CLAVE, $claveAplicacion);
        $c -> addJoin(EdaAplicacionesPeer::ID, EdaConfpersonalesPeer::ID_APLICACION);
        $c -> add(EdaConfpersonalesPeer::ID_USUARIO, $id_usuario);

        $confP = EdaConfpersonalesPeer::doSelectOne($c);


        if($confP instanceof EdaConfpersonales)
        {
            $id_perfil  = $confP -> getIdPerfil();
            $id_ambito  = $confP -> getIdAmbito();
            $id_periodo = $confP -> getIdPeriodo();

            $oConfPersonal = new edaConfPersonal($id_usuario, $id_perfil, $id_ambito, $id_periodo);
        }
        else
        {
            $oConfPersonal = new edaConfPersonal($id_usuario);
        }

        return $oConfPersonal;

    }
}


