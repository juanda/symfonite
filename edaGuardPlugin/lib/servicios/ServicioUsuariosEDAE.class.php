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

class ServicioUsuariosEDAE extends ServicioUsuarios
{
    public function usuario($in)
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

        $edaUsuario = self::dameEdaUsuario($in);

        if($edaUsuario instanceof EdaUsuarios)
        {
            $usuario     = array();
            $telefonos   = array();
            $emails      = array();
            $direcciones = array();

            $c = new Criteria();
            $c -> add(sfGuardUserPeer::ID, $edaUsuario -> getIdSfuser());
            $sfUsuario = sfGuardUserPeer::doSelectOne($c);

            $usuario['identificacion']['alias']      = $edaUsuario -> getAlias();
            $usuario['identificacion']['edaId']      = $edaUsuario -> getId();
            $usuario['identificacion']['username']   = $sfUsuario  -> getUsername();
            $usuario['identificacion']['sfId']       = $sfUsuario  -> getId();
            $usuario['identificacion']['fecha_alta'] = $sfUsuario  -> getCreatedAt();


            $usuario['activo']       = $edaUsuario -> getActivo();
            $usuario['fecha_alta']   = $edaUsuario -> getCreatedAt();
            $usuario['fecha_baja']   = $edaUsuario -> getFechaBaja();
            $usuario['cultura_pref'] = $edaUsuario -> getIdCulturapref();


            if(is_null($edaUsuario -> getIdPersona()) && !is_null($edaUsuario -> getIdOrganismo()))
            {
                if(!($edaUsuario -> getEdaOrganismos() instanceof EdaOrganismos))
                {
                    $out['status'] = Servicio::NO_CONTENT;
                    return $out;
                }
                $usuario['tipo']          = 'organismo';
                $usuario['nombre']        = $edaUsuario -> getEdaOrganismos() -> getNombre();
                $usuario['abreviatura']   = $edaUsuario -> getEdaOrganismos() -> getAbreviatura();
                if($edaUsuario -> getEdaOrganismos() -> getEdaTiposorganismo() instanceof  EdaTiposorganismo)
                {
                    $usuario['tipo_organismo'] = $edaUsuario -> getEdaOrganismos() -> getEdaTiposorganismo() -> getNombre();
                }
                $usuario['codigo']        = $edaUsuario -> getEdaOrganismos() -> getCodigo();
                $usuario['descripcion']   = $edaUsuario -> getEdaOrganismos() -> getDescripcion();
                $usuario['sitioweb']      = $edaUsuario -> getEdaOrganismos() -> getSitioWeb();
                if($edaUsuario -> getEdaOrganismos() -> getGenPaises() instanceof GenPaises)
                {
                    $usuario['pais']          = $edaUsuario -> getEdaOrganismos() -> getGenPaises() -> getNombre();
                }
                $telefonos   = $edaUsuario -> getEdaOrganismos() -> getEdaTelefonoss();
                $emails      = $edaUsuario -> getEdaOrganismos() -> getEdaEmailss();
                $direcciones = $edaUsuario -> getEdaOrganismos() -> getEdaDireccioness();

                if(!is_null($edaUsuario -> getEdaOrganismos() -> getIdContacto()))
                {
                    $usuario['contacto']['nombre']          = $edaUsuario -> getEdaOrganismos() -> getEdaPersonas() -> getNombre();
                    $usuario['contacto']['apellido1']       = $edaUsuario -> getEdaOrganismos() -> getEdaPersonas() -> getApellido1();
                    $usuario['contacto']['apellido2']       = $edaUsuario -> getEdaOrganismos() -> getEdaPersonas() -> getApellido2();
                    if($edaUsuario -> getEdaOrganismos() -> getEdaPersonas() -> getEdaTiposDocidentificacion() instanceof  EdaTiposdocidentificacion)
                    {
                        $usuario['contacto']['tipo_doc_id']     = $edaUsuario -> getEdaOrganismos() -> getEdaPersonas() -> getEdaTiposDocidentificacion() -> getNombre();
                    }
                    $usuario['contacto']['doc_id']          = $edaUsuario -> getEdaOrganismos() -> getEdaPersonas() -> getDocidentificacion();
                    if($edaUsuario -> getEdaOrganismos() -> getEdaPersonas() -> getGenPaises() instanceof GenPaises)
                    {
                        $usuario['contacto']['pais_doc_id']     = $edaUsuario -> getEdaOrganismos() -> getEdaPersonas() -> getGenPaises() -> getNombre();
                    }
                    $usuario['contacto']['sexo']            = $edaUsuario -> getEdaOrganismos() -> getEdaPersonas() -> getSexo();
                    $usuario['contacto']['fechanacimiento'] = $edaUsuario -> getEdaOrganismos() -> getEdaPersonas() -> getFechanacimiento();
                    $usuario['contacto']['profesion']       = $edaUsuario -> getEdaOrganismos() -> getEdaPersonas() -> getProfesion();
                    $usuario['contacto']['observaciones']   = $edaUsuario -> getEdaOrganismos() -> getEdaPersonas() -> getObservaciones();
                    $usuario['contacto']['fecha_alta']      = $edaUsuario -> getEdaOrganismos() -> getEdaPersonas() -> getCreatedAt();
                    $usuario['contacto']['cargo']           = $edaUsuario -> getEdaOrganismos() -> getCargo();
                }
            }
            else if(!is_null($edaUsuario -> getIdPersona()) && is_null($edaUsuario -> getIdOrganismo()))
            {
                if(!($edaUsuario -> getEdaPersonas() instanceof EdaPersonas))
                {
                    $out['status'] = Servicio::NO_CONTENT;
                    return $out;
                }
                $usuario['tipo'] = 'persona';
                $usuario['nombre']          = $edaUsuario -> getEdaPersonas() -> getNombre();
                $usuario['apellido1']       = $edaUsuario -> getEdaPersonas() -> getApellido1();
                $usuario['apellido2']       = $edaUsuario -> getEdaPersonas() -> getApellido2();
                if($edaUsuario -> getEdaPersonas() -> getEdaTiposDocidentificacion() instanceof EdaTiposdocidentificacion)
                {
                    $usuario['tipo_doc_id']     = $edaUsuario -> getEdaPersonas() -> getEdaTiposDocidentificacion() -> getNombre();
                }
                $usuario['doc_id']          = $edaUsuario -> getEdaPersonas() -> getDocidentificacion();
                if($edaUsuario -> getEdaPersonas() -> getGenPaises() instanceof GenPaises)
                {
                    $usuario['pais_doc_id']     = $edaUsuario -> getEdaPersonas() -> getGenPaises() -> getNombre();
                }
                $usuario['sexo']            = $edaUsuario -> getEdaPersonas() -> getSexo();
                $usuario['fechanacimiento'] = $edaUsuario -> getEdaPersonas() -> getFechanacimiento();
                $usuario['profesion']       = $edaUsuario -> getEdaPersonas() -> getProfesion();
                $usuario['observaciones']   = $edaUsuario -> getEdaPersonas() -> getObservaciones();
                $usuario['fecha_alta']      = $edaUsuario -> getEdaPersonas() -> getCreatedAt();

                $telefonos   = $edaUsuario -> getEdaPersonas() -> getEdaTelefonoss();
                $emails      = $edaUsuario -> getEdaPersonas() -> getEdaEmailss();
                $direcciones = $edaUsuario -> getEdaPersonas() -> getEdaDireccioness();

            }
            else
            {
                $usuario['tipo'] = 'no asociado';
            }

            $i = 0;
            foreach ($telefonos as $t)
            {
                $usuario['telefonos'][$i]['telefono']['numero'] = $t -> getNumeroTelefono();
                $usuario['telefonos'][$i++]['telefono']['tipo']   = $t -> getEdaTiposTelefono() -> getNombre();
            }

            $i = 0;
            foreach ($emails as $e)
            {
                $usuario['emails'][$i]['email']['direccion']       = $e -> getDireccion();
                $usuario['emails'][$i++]['email']['predeterminado']  = ($e -> getPredeterminado() == 1)? 'si' : 'no';
            }

            $i = 0;
            foreach ($direcciones as $d)
            {
                $usuario['direcciones'][$i]['direccion']['tipo']      = $d -> getEdaTiposDireccion() -> getNombre();
                $usuario['direcciones'][$i]['direccion']['tipo_via']  = $d -> getTipoVia();
                $usuario['direcciones'][$i]['direccion']['domicilio'] = $d -> getDomicilio();
                $usuario['direcciones'][$i]['direccion']['numero']    = $d -> getNumero();
                $usuario['direcciones'][$i]['direccion']['escalera']  = $d -> getEscalera();
                $usuario['direcciones'][$i]['direccion']['piso']      = $d -> getPiso();
                $usuario['direcciones'][$i]['direccion']['letra']     = $d -> getLetra();
                $usuario['direcciones'][$i]['direccion']['municipio'] = $d -> getMunicipio();
                $usuario['direcciones'][$i]['direccion']['provincia'] = $d -> getProvincia();
                $usuario['direcciones'][$i]['direccion']['pais']      = $d -> getPais();
                $usuario['direcciones'][$i++]['direccion']['cp']      = $d -> getCp();
            }


            $out['status']  = Servicio::OK ;
            $out['usuario'] = $usuario;
        }
        else
        {
            $out['status'] = Servicio::NOT_FOUND;
        }

        return $out;
    }

    /**
     * Devuelve informacion sobre las credenciales que tiene un usuario
     * en una aplicación identificada por su clave.
     *
     *  Los estados de salida pueden ser:
     * -> BAD_REQUEST si la interfaz uniforme de entrada no es válida
     * -> NOT_FOUND   si el usuario no existe
     * -> OK          si se han recuperdado los datos de un usuario
     *
     * @param array $in
     *               |- id
     *               |- tipoId
     *               `- clave_aplicacion
     * @return $out
     *          |-status
     *          |
     *          `-credenciales
     */
    public function credencialesDelUsuarioEnAplicacion($in)
    {
        ///////////////////////////////////////////
        // comprobación de la interfaz de entrada//
        ///////////////////////////////////////////
        if(!isset($in['id']) || !isset($in['tipoId']) || !isset($in['clave_aplicacion']))
        {
            $out['status'] = Servicio::BAD_REQUEST;
            return $out;
        }
        ///////////////////////////////////////////

        $usuario = self::dameEdaUsuario($in);

        if(!($usuario instanceof EdaUsuarios))
        {
            $out['status'] = Servicio::NOT_FOUND;
            return $out;
        }

        $c = new Criteria();

        $c -> add(EdaAplicacionesPeer::CLAVE, $in['clave_aplicacion']);
        $c -> addJoin(EdaAplicacionesPeer::ID, EdaCredencialesPeer::ID_APLICACION);
        $c -> addJoin(EdaCredencialesPeer::ID, EdaPerfilCredencialPeer::ID_CREDENCIAL);
        $c -> addJoin(EdaPerfilCredencialPeer::ID_PERFIL, EdaPerfilesPeer::ID);
        $c -> addJoin(EdaPerfilesPeer::ID, EdaAccesosPeer::ID_PERFIL);
        $c -> addJoin(EdaAccesosPeer::ID_USUARIO, EdaUsuariosPeer::ID);
        $c -> add(EdaUsuariosPeer::ID, $usuario -> getId());

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
     * Devuelve informacion sobre los perfiles que tiene un usuario
     * en una aplicación identificada por su clave.
     *
     *  Los estados de salida pueden ser:
     * -> BAD_REQUEST si la interfaz uniforme de entrada no es válida
     * -> NOT_FOUND   si el usuario no existe
     * -> OK          si se han recuperdado los datos de un usuario
     *
     * @param array $in
     *               |- id
     *               |- tipoId
     *               `- clave_aplicacion
     * @return $out
     *          |-status
     *          |
     *          `-perfiles
     */
    public function perfilesDelUsuarioEnAplicacion($in)
    {
        ///////////////////////////////////////////
        // comprobación de la interfaz de entrada//
        ///////////////////////////////////////////
        if(!isset($in['id']) || !isset($in['tipoId']) || !isset($in['clave_aplicacion']))
        {
            $out['status'] = Servicio::BAD_REQUEST;
            return $out;
        }
        ///////////////////////////////////////////

        $usuario = self::dameEdaUsuario($in);

        if(!($usuario instanceof EdaUsuarios))
        {
            $out['status'] = Servicio::NOT_FOUND;
            return $out;
        }

        $c = new Criteria();
//        $c -> add(EdaUsuariosPeer::ID, $usuario -> getId());
//        $c -> addJoin(EdaUsuariosPeer::ID, EdaAccesosPeer::ID_USUARIO);
//        $c -> addJoin(EdaAccesosPeer::ID_PERFIL, EdaPerfilesPeer::ID);
//        $c -> addJoin(EdaPerfilesPeer::ID, EdaPerfilCredencialPeer::ID_PERFIL);
//        $c -> addJoin(EdaCredencialesPeer::ID_APLICACION, EdaAplicacionesPeer::ID);
//        $c -> add(EdaAplicacionesPeer::CLAVE, $in['clave_aplicacion']);
//        $c -> addJoin(EdaPerfilesPeer::ID_UO, EdaUosPeer::ID);
//        $c -> addAscendingOrderByColumn(EdaPeriodosPeer::ID);
//        $c -> setDistinct();

        $c -> add(EdaAplicacionesPeer::CLAVE, $in['clave_aplicacion']);
        $c -> addJoin(EdaAplicacionesPeer::ID, EdaCredencialesPeer::ID_APLICACION);
        $c -> addJoin(EdaCredencialesPeer::ID, EdaPerfilCredencialPeer::ID_CREDENCIAL);
        $c -> addJoin(EdaPerfilCredencialPeer::ID_PERFIL, EdaPerfilesPeer::ID);
        $c -> addJoin(EdaPerfilesPeer::ID, EdaAccesosPeer::ID_PERFIL);
        $c -> addJoin(EdaPerfilesPeer::ID_UO,EdaUosPeer::ID);
        $c -> addJoin(EdaUosPeer::ID, EdaPeriodosPeer::ID_UO);
        $c -> add(EdaAccesosPeer::ID_USUARIO, $usuario -> getId());
        $c -> addAscendingOrderByColumn(EdaPeriodosPeer::ID);
        $c -> setDistinct();

        $tEAs = EdaPeriodosPeer::doSelect($c);

        // Recorremos todos esos ejercicios academicos en busca de:
        // -> perfiles con ámbitos en ellos
        // -> perfiles que no tienen ambitos definidos (id_ambito=NULL en la tabla EDA_TiposAmbito)
        // La información que se va a mostrar se recoge en el array $tInfoPerfiles
        $tInfoPerfiles = array();
        $i=0;
        foreach ($tEAs as $ea)
        {
            // Pillamos los perfiles del usuario en la uo del periodo en cuestion
            // con credenciales en la aplicación
            $c -> clear();
            $c -> add(EdaAplicacionesPeer::CLAVE,$in['clave_aplicacion'] );
            $c -> addJoin(EdaCredencialesPeer::ID_APLICACION, EdaAplicacionesPeer::ID);
            $c -> addJoin(EdaPerfilCredencialPeer::ID_CREDENCIAL, EdaCredencialesPeer::ID);
            $c -> addJoin(EdaPerfilesPeer::ID, EdaPerfilCredencialPeer::ID_PERFIL);
            $c -> add(EdaPerfilesPeer::ID_UO, $ea -> getEdaUos() -> getId());
            $c -> addJoin(EdaPerfilesPeer::ID, EdaAccesosPeer::ID_PERFIL);
            $c -> add(EdaAccesosPeer::ID_USUARIO, $usuario -> getId());
            $c -> setDistinct();
            $c -> addAscendingOrderByColumn(EdaPerfilesPeer::ID);

            $tPerfiles = EdaPerfilesPeer::doSelect($c);


//            echo '<pre>';
//            print_r($ea -> getEdaUos()-> getNombre());
//            echo '<br>';
//            echo '============';
//            echo '<br>';
//            foreach ($tPerfiles as $perfil)
//            {
//                echo $perfil -> getNombre();
//                echo '<br>';
//            }
//            echo count($tPerfiles);
//            echo '<br>';
//            echo '------------';
//            echo '<br>';

            if(count($tPerfiles)>0)
            {
                $i++;

                $tInfoPerfiles[$i]['id_ea'] = $ea -> getId();
                $tInfoPerfiles[$i]['descripcion_ea'] = $ea -> getDescripcion();
                $tInfoPerfiles[$i]['id_uo'] = $ea -> getIdUo();
                $tInfoPerfiles[$i]['codigo_uo'] = $ea -> getEdaUos()->getCodigo();
                $tInfoPerfiles[$i]['nombre_uo'] = $ea -> getEdaUos()->getNombre();

                $j=0;
                foreach($tPerfiles as $perfil)
                {
                    $j++;

                    $tInfoPerfiles[$i]['perfiles'][$j]['id_perfil']   = $perfil->getId();
                    $tInfoPerfiles[$i]['perfiles'][$j]['nombre_perfil']   = $perfil -> getNombre();
                    $tInfoPerfiles[$i]['perfiles'][$j]['descripcion_perfil']   = $perfil -> getDescripcion();

                    // Pillamos los ambitos del perfil a través del objeto acceso
                    $c -> clear();
                    $c -> add(EdaAccesosPeer::ID_USUARIO, $usuario -> getId());
                    $c -> add(EdaAccesosPeer::ID_PERFIL, $perfil->getId());
                    $tAcceso = $usuario -> getEdaAccesoss($c);

                    // Ámbitos
                    if(!is_null($perfil -> getIdAmbitoTipo()) && count($tAcceso) > 0)
                    {
                        $c -> clear();
                        $c -> add(EdaAmbitosPeer::ID_PERIODO, $ea -> getId());
                        $c -> addJoin(EdaAmbitosPeer::ID, EdaAccesoAmbitoPeer::ID_AMBITO );
                        $tAccesosAmbitos = $tAcceso[0] -> getEdaAccesoAmbitos($c); // Sólo debe haber un acceso
                        if(count($tAccesosAmbitos) == 0) // El perfil no tiene ambitos en ese ejercicio academico

                        {
                            // Eliminamos ese perfil de la lista
                            unset($tInfoPerfiles[$i]['perfiles'][$j]);
                            $j--;
                        }
                        else
                        {
                            $k=0;
                            foreach ($tAccesosAmbitos as $ab)
                            {
                                $k++;
                                $tInfoPerfiles[$i]['perfiles'][$j]['ambitos'][$k]['id'] = $ab-> getIdAmbito();
                                $tInfoPerfiles[$i]['perfiles'][$j]['ambitos'][$k]['ejeracad'] = $ab -> getEdaAmbitos() -> getIdPeriodo();
                                $tInfoPerfiles[$i]['perfiles'][$j]['ambitos'][$k]['nombre'] = $ab -> getEdaAmbitos() -> getNombre();
                            }
                        }
                    }
                    else // perfil sin ambitos

                    {
                        $tInfoPerfiles[$i]['perfiles'][$j]['ambitos'][1]['nombre'] = 'no_ambitos' ;
                        $tInfoPerfiles[$i]['perfiles'][$j]['ambitos'][1]['id']     = null;
                    }

                }

                if(count($tInfoPerfiles[$i]['perfiles']) == 0) // No hay ningún perfil en ese periodo

                {
                    unset($tInfoPerfiles[$i]);
                    $i--;
                }
            }
        }
        if(count($tInfoPerfiles) == 0)
        {
            $out['status'] = Servicio::NO_CONTENT;
        }
        else
        {
            $out['status'] = Servicio::OK;
            $out['perfiles'] = $tInfoPerfiles;
        }
//        echo '<pre>';
//        print_r($out);
//        echo '</pre>';
//        exit;
        return $out;
    }

    /**
     * Devuelve información sobre la configuración personal de un usuario en
     * una aplicación determinada
     *
     *
     * Los estados de salida pueden ser:
     * -> BAD_REQUEST            si la interfaz uniforme de entrada no es válida
     * -> NO_CONTENT             si alguno de los parámetros de la configuración personal
     *                           no se han podido hallar
     * -> INTERNAL_SERVER_ERROR  si el servicio ha fallado debido a una incongruencia
     *                           de los datos.
     * -> OK                     si se han recuperdado los datos de un usuario
     *
     * @param array $in
     *               |- id                 -> identificador del usuario
     *               |- tipoId             -> tipo de identificador
     *               `- clave_aplicacion   -> clave de la aplicación
     *
     * @return array $out
     *                |- status
     *                `- configuracion_personal
     *                   |- valida
     *                   |- mensaje
     *                   |- id_perfil
     *                   |- id_ambito
     *                   |- id_uo
     *                   |- id_periodo
     *                   `- cultura_pref
     */
    public function configuracionPersonalEnAplicacion($in)
    {
        ///////////////////////////////////////////
        // comprobación de la interfaz de entrada//
        ///////////////////////////////////////////
        if(!isset($in['id']) || !isset($in['tipoId']) || !isset($in['clave_aplicacion']))
        {
            $out['status'] = Servicio::BAD_REQUEST;
            return $out;
        }
        ///////////////////////////////////////////

        $in_usuario = array('id' => $in['id'], 'tipoId' => $in['tipoId']);
        $serv = Servicio::crearServicioUsuario();
        $out_usuario = $serv -> usuario($in_usuario);
        $usuario = $out_usuario['usuario'];

        $id_usuario = $usuario['identificacion']['edaId']; // Necesito este Id para que el resto funcione

        $confPersonal = array();
        //Busco perfil

        // Buscamos la configuración personal que haya en la base de datos

        $confPersonal = self::obtenerConfPersonasDeBaseDatos($id_usuario, $in['clave_aplicacion']);

        if($confPersonal -> esValida())
        {
            $confPersonal['id_perfil']    = $confPersonal -> dameIdPerfil();
            $confPersonal['id_ambito']    = $confPersonal -> dameIdAmbito();
            ;
            $confPersonal['id_uo']        = $confPersonal -> dameIdUnidadOrganizativa();
            $confPersonal['id_periodo']   = $confPersonal -> dameIdPeriodo();
        }
        else
        {

            $eIdPerfil = self::obtenerPerfilPredeterminadoEnAplicacion($id_usuario, $in['clave_aplicacion']);

            if(is_null($eIdPerfil))
            {
                $eIdPerfil = self::obtenerPrimerPerfilUsuarioEnAplicacion($id_usuario, $in['clave_aplicacion']);
                if(is_null($eIdPerfil)) // el usuario no tiene ningún perfil en la aplicación

                {
                    $out['status']  = Servicio::NO_CONTENT;
                    $out['configuracion_personal']['valida']  = false;
                    $out['configuracion_personal']['mensaje'] = 'No se encuentra perfil en la aplicación';

                    return $out;
                }
            }

            //Miro si el perfil necesita ámbito o no
            $oPerfil = EdaPerfilesPeer::retrieveByPK($eIdPerfil);
            if(is_null($oPerfil)) // Error del servicio

            {
                $out['status'] = Servicio::INTERNAL_SERVER_ERROR;
                return $out;
            }
            $eIdUO = $oPerfil->getIdUo();
            $marca = $oPerfil -> getEdaUos() -> getMarca();
            if(is_null($oPerfil)) // Error del servicio

            {
                $out['status'] = Servicio::INTERNAL_SERVER_ERROR;
                return $out;
            }

            $eIdAmbito = $oPerfil->getIdAmbito();

            if(is_null($eIdAmbito))
            {
                //Este perfil no necesita ámbito
                //miro a ver si hay algún EA activo asociado a la UO
                $eIdPeriodo = self::obtenerPeriodoActivo($eIdUO);
                if(is_null($eIdPeriodo))
                {
                    $out['status'] = Servicio::NO_CONTENT;
                    $out['configuracion_personal']['valida']  = false;
                    $out['configuracion_personal']['mensaje'] = 'No hay periodos activos para la UO';
                    return $out;
                }
                $confPersonal['id_perfil']    = $eIdPerfil;
                $confPersonal['id_ambito']    = null;
                $confPersonal['id_uo']        = $eIdUO;
                $confPersonal['id_periodo']   = $eIdPeriodo;
                $confPersonal['cultura_pref'] = $usuario['cultura_pref'];
                $confPersonal['marca']        = $marca;
            }
            else
            {
                // Este perfil necesita ámbito, hay que buscar uno (en estas búsqueda se incluye la comprobación del ejercicio académico)
                // Averiguámos primero cuál es la tabla (clase propel) de dicho ámbito
                //              $oAmbito       = EdaAmbitosPeer::retrieveByPK($eIdAmbito);
                //              $aTablaAmbito  = $oAmbito -> getTabla();
                //              $aClasePeer    = sfInflector::camelize('eda_accesos_'.$aTablaAmbito).'Peer';
                //              $aTablaAccesosAmbito = "eda_accesos_".$aTablaAmbito;
                //Ahora buscamos el ámbito predeterminado y, si no, uno cualquiera válido
                $eIdAmbito = self::obtenerAmbitoPredeterminadoEnAplicacion($id_usuario, $eIdPerfil, $clave_aplicacion);
                if(is_null($eIdAmbito))
                {
                    $eIdAmbito = self::obtenerAmbitoPerfilEnAplicacion($id_usuario, $eIdPerfil, $clave_aplicacion);
                }
                if(is_null($eIdAmbito))
                {
                    $out['status'] = Servicio::NO_CONTENT;
                    $out['configuracion_personal']['valida']  = false;
                    $out['configuracion_personal']['mensaje'] = 'No se encuentra el ambito';
                    return $out;
                }
                $confPersonal['id_perfil']    = $eIdPerfil;
                $confPersonal['id_ambito']    = $eIdAmbito;
                $confPersonal['id_uo']        = $eIdUO;
                $confPersonal['id_periodo']   = $this->obtenerPeriodoAmbito($eIdAmbito);
                $confPersonal['cultura_pref'] = $usuario['cultura_pref'];
                $confPersonal['marca']        = $marca;
            }
        }

        $out['status'] = Servicio::OK;
        $out['configuracion_personal'] = $confPersonal;
        $out['configuracion_personal']['valida']  = true;
        $out['configuracion_personal']['mensaje'] = 'OK';

        return $out;
    }

    public function aplicacionesDelUsuario($in)
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

        $in_usuario = array('id' => $in['id'], 'tipoId' => $in['tipoId']);
        $serv = Servicio::crearServicioUsuario();
        $out_usuario = $serv -> usuario($in_usuario);
        $usuario = $out_usuario['usuario'];

        $id_usuario = $usuario['identificacion']['edaId'];

        $c = new Criteria();

        $c -> add(EdaAccesosPeer::ID_USUARIO, $id_usuario);
        $c -> addJoin(EdaAccesosPeer::ID_PERFIL, EdaPerfilCredencialPeer::ID_PERFIL);
        $c -> addJoin(EdaPerfilCredencialPeer::ID_CREDENCIAL, EdaCredencialesPeer::ID);
        $c -> addJoin(EdaCredencialesPeer::ID_APLICACION, EdaAplicacionesPeer::ID);
        $c -> setDistinct();

        $tAplicaciones = EdaAplicacionesPeer::doSelect($c);

        $aplicaciones = array();
        $i=0;
        foreach ($tAplicaciones as $aplicacion)
        {
            $aplicaciones[$i]['id'] = $aplicacion -> getId();
            $aplicaciones[$i]['codigo'] = $aplicacion -> getCodigo();
            $aplicaciones[$i]['nombre'] = $aplicacion -> getNombre();
            $aplicaciones[$i]['descripcion'] = $aplicacion -> getDescripcion();
            $aplicaciones[$i]['logotipo'] = $aplicacion -> getLogotipo();
            $aplicaciones[$i]['url'] = $aplicacion -> getUrl();
            $aplicaciones[$i]['url_svn'] = $aplicacion -> getUrlSvn();
            $aplicaciones[$i]['clave'] = $aplicacion -> getClave();
            $aplicaciones[$i]['id_credencial'] = $aplicacion -> getIdCredencial();

            $i++;
        }

        if(count($aplicaciones) == 0)
        {
            $out['status'] = Servicio::NO_CONTENT;
            return $out;
        }
        else
        {
            $out['status']       = Servicio::OK;
            $out['aplicaciones'] = $aplicaciones;
        }

        return $out;
    }

    protected function obtenerPerfilPredeterminadoEnAplicacion($id_usuario, $clave_aplicacion)
    {
        $c = new Criteria();
        $c -> add(EdaAplicacionesPeer::CLAVE, $clave_aplicacion);
        $c -> addJoin(EdaAplicacionesPeer::ID, EdaCredencialesPeer::ID_APLICACION);
        $c -> addJoin(EdaCredencialesPeer::ID, EdaPerfilCredencialPeer::ID_CREDENCIAL);
        $c -> addJoin(EdaPerfilCredencialPeer::ID_PERFIL, EdaPerfilesPeer::ID);
        $c -> addJoin(EdaPerfilesPeer::ID, EdaAccesosPeer::ID_PERFIL);
        $c->add(EdaAccesosPeer::ID_USUARIO,$id_usuario,Criteria::EQUAL);
        $c->add(EdaAccesosPeer::ESINICIAL,1,Criteria::EQUAL);
        $oAcceso = EdaAccesosPeer::doSelectOne($c);
        if(is_null($oAcceso))
        {
            return null;
        }
        else
        {
            return $oAcceso->getIdPerfil();
        }
    }

    protected function obtenerPrimerPerfilUsuarioEnAplicacion($id_usuario, $clave_aplicacion)
    {
        $c = new Criteria();
        $c -> add(EdaAplicacionesPeer::CLAVE, $clave_aplicacion);
        $c -> addJoin(EdaAplicacionesPeer::ID, EdaCredencialesPeer::ID_APLICACION);
        $c -> addJoin(EdaCredencialesPeer::ID, EdaPerfilCredencialPeer::ID_CREDENCIAL);
        $c -> addJoin(EdaPerfilCredencialPeer::ID_PERFIL, EdaPerfilesPeer::ID);
        $c -> addJoin(EdaPerfilesPeer::ID, EdaAccesosPeer::ID_PERFIL);
        $c->add(EdaAccesosPeer::ID_USUARIO,$id_usuario,Criteria::EQUAL);

        $oAcceso = EdaAccesosPeer::doSelectOne($c);
        if(is_null($oAcceso))
        {
            return null;
        }
        else
        {
            return $oAcceso->getIdPerfil();
        }
    }

}