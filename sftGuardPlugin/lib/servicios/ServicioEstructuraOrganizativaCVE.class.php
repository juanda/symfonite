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

class ServicioEstructuraOrganizativaCVE extends ServicioEstructuraOrganizativa
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


    $cvePerfil = TiposPeer::retrieveByPK($in['id']);

    if(! ($cvePerfil instanceof Tipos))
    {
      $out['status'] = Servicio::NOT_FOUND;
      return $out;
    }

    $perfil = array();

    $perfil['nombre']       = $cvePerfil -> getNombre();
    $perfil['descripcion']  = $cvePerfil -> getDescripcion();
    $perfil['abreviatura']  = $cvePerfil -> getNombreAbrev();
    $perfil['ambito']       = $cvePerfil -> getTipoAmbito();
    $menu = $cvePerfil -> getArchivo();
    $perfil['menu']         = ($menu[strlen($menu) - 1] == '.')?  $cvePerfil -> getArchivo().'yml' :  $cvePerfil -> getArchivo().'.yml';
    $perfil['uo']['id']     = $cvePerfil -> getIDUO();
    $perfil['uo']['nombre'] = $cvePerfil -> getUos() -> getNombre();
    $perfil['uo']['marca']  = $cvePerfil -> getUos() -> getMarca();

    // Credenciales

    $perfil_credencial = $cvePerfil -> getFuncTiposJoinFuncionalidades();
    $i = 0;
    foreach ($perfil_credencial as $pc)
    {
      $perfil['credenciales'][$i]['credencial']['id']           = $pc -> getFuncionalidades() ->  getId();
      $perfil['credenciales'][$i]['credencial']['nombre']       = $pc -> getFuncionalidades() ->  getNombre();
      $perfil['credenciales'][$i]['credencial']['descripcion']  = $pc -> getFuncionalidades() -> getNombre() .' - '. $pc -> getFuncionalidades() -> getDescripcion();
      $perfil['credenciales'][$i++]['credencial']['aplicacion'] = 'cve';
    }

    $out['status'] = Servicio::OK;
    $out['perfil'] = $perfil;

    return $out;
  }

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

    $persona = self::dameCVEUsuario($in);


    if(!($persona instanceof Personas))
    {
      $out['status'] = Servicio::NOT_FOUND;
      return $out;
    }

    $c = new Criteria();

    $c->addJoin(UsuariosPeer::ID_TIPO , TiposPeer::ID );
    $c->addJoin(TiposPeer::ID_UO , UosPeer::ID  );
    $c->addJoin(EjerciciosacademicosPeer::ID_UO , UosPeer::ID  );
    $c->addAscendingOrderByColumn(UosPeer::ID );
    $c->addAscendingOrderByColumn(EjerciciosacademicosPeer::ID  );

    $c->add(UsuariosPeer::ESTADO , 'ACTIVO');
    $c->add(EjerciciosacademicosPeer::FASE  , 'ABIERTO');

    $c->add(UsuariosPeer::ID_PERSONA  , $persona -> getId());
    $c->add(UsuariosPeer::ESTADO , 'ACTIVO');
    $c->addAscendingOrderByColumn(UsuariosPeer::ID_TIPO );
    $c->setDistinct();

    $tEAs = EjerciciosacademicosPeer::doSelect($c);

    // Recorremos todos esos ejercicios academicos en busca de:
    // -> perfiles con ámbitos en ellos
    // -> perfiles que no tienen ambitos definidos (id_ambito=NULL en la tabla EDA_TiposAmbito)
    // La información que se va a mostrar se recoge en el array $tInfoPerfiles

    $tInfoPerfiles = array();
    $i=0;
    foreach ($tEAs as $ea)
    {
      $tInfoPerfiles[$i]['id_ea']          = $ea -> getId();
      $tInfoPerfiles[$i]['descripcion_ea'] = $ea -> getDescripcion();
      $tInfoPerfiles[$i]['id_uo']          = $ea -> getIDUO();
      $tInfoPerfiles[$i]['codigo_uo']      = $ea -> getUos() -> getNombre();
      $tInfoPerfiles[$i]['nombre']         = $ea -> getUos() -> getNombre();

      // Pillamos los perfiles del usuario en esa uo

      // $id = $usuario->getId();

      $c -> clear();
      $c -> add(UsuariosPeer::ID_PERSONA , $persona -> getId());
      $c -> addJoin(UsuariosPeer::ID_TIPO, TiposPeer::ID);
      $c -> addJoin(TiposPeer::ID_UO, UosPeer::ID);
      $c -> add(UosPeer::ID, $ea -> getIDUO());
      $c->addAscendingOrderByColumn(UsuariosPeer::ID_TIPO );

      $tUsuarios = UsuariosPeer::doSelect($c);

      $j=0;
      foreach($tUsuarios as $usuario)
      {
        $tInfoPerfiles[$i]['perfiles'][$j]['id_perfil']            = $usuario -> getTipos() -> getId();
        $tInfoPerfiles[$i]['perfiles'][$j]['nombre_perfil']        = $usuario -> getTipos() -> getNombre();
        $tInfoPerfiles[$i]['perfiles'][$j]['descripcion_perfil']   = $usuario -> getTipos() -> getDescripcion();

        $tAmbitos = $usuario -> dameIDAmbitos($ea->getId());


        if(is_null($tAmbitos)) // perfil sin ambitos

        {
          $tInfoPerfiles[$i]['perfiles'][$j]['ambitos'][0]['nombre'] = 'no_ambitos' ;
        }
        else if(count($tAmbitos) == 0) // El perfil no tiene ambitos en ese ejercicio academico

        {
          // Eliminamos ese perfil de la lista
          unset($tInfoPerfiles[$i]['perfiles'][$j]);
          $j--;
        }
        else
        {
          $k=0;
          foreach ($tAmbitos as $ambito)
          {
            $tInfoPerfiles[$i]['perfiles'][$j]['ambitos'][$k]['id']       = $ambito['id'];
            $tInfoPerfiles[$i]['perfiles'][$j]['ambitos'][$k]['id_ea'] = $ea -> getId();
            $tInfoPerfiles[$i]['perfiles'][$j]['ambitos'][$k]['nombre']   = $ambito['nombre'];
            $k++;
          }
        }
        $j++;
      }
      $i++;
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
    return $out;
  }

  public function ambito($in)
  {
    ///////////////////////////////////////////
    // comprobación de la interfaz de entrada//
    ///////////////////////////////////////////
    if(!isset($in['id']) || !isset($in['ambito']))
    {
      $out['status'] = Servicio::BAD_REQUEST;
      return $out;
    }
    ///////////////////////////////////////////

    $nombreAmbito = $this -> dameNombreAmbito($in['id'], $in['ambito']);
    $ambito['nombre']      = $nombreAmbito;
    $ambito['descripcion'] = $nombreAmbito;
    $ambito['fechaAlta']   = '';
    $ambito['idPeriodo']   = '';

    $out['status'] = Servicio::OK;
    $out['ambito'] = $ambito;

    return $out;
  }

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

    $cvePeriodo = EjerciciosacademicosPeer::retrieveByPK($in['id']);

    if(!($cvePeriodo instanceof Ejerciciosacademicos))
    {
      $out['status'] = Servicio::NOT_FOUND;
      return $out;
    }

    $periodo['fecha_inicio'] = $cvePeriodo -> getFechaInicio();
    $periodo['fecha_fin']    = $cvePeriodo -> getFechaFin();
    $periodo['descripcion']  = $cvePeriodo -> getDescripcion();
    $periodo['estado']       = $cvePeriodo -> getEstado();

    $out['status']  = Servicio::OK;
    $out['periodo'] = $periodo;

    return $out;
  }

  protected function comprobarConfiguracionPersonal($confPersonal, $id_usuario)
  {
    $out = false;
    $idPersona = $confPersonal -> getIdPersona();
    $idPerfil = $confPersonal -> getPerfilPref();
    $idUO = $confPersonal -> getUoPref();
    $idAmbito = $confPersonal -> getAmbitoPref();
    $idEA = $confPersonal -> getEaPref();

    if (($idPersona) && ($idUO) && ($idPerfil) && ($idAmbito) && ($idEA))  // Comprueba que no haya campos vacíos o nulos
    {
      $oUO = UosPeer::retrieveByPK($idUO);

      if (($oUO instanceof Uos)) // La UO está OK.
      {
        $oEA = EjerciciosacademicosPeer::retrieveByPK($idEA);

        if (($oEA instanceof Ejerciciosacademicos)) // EA válido de la Conf. Personal
        {
          if ( ($oEA -> getIdUo() == $oUO->getId()) && ($oEA -> getEstado() == 1) ) // Es el activo para la UO de la conf. personal

          {
            $oTipo = TiposPeer::retrieveByPK($confPersonal -> getPerfilPref());

            if (($oTipo instanceof Tipos)) // Tipo válido de la Conf. Personal
            {
              if ( ($oTipo -> getIdUo() == $idUO) ) // Es un perfil de la UO --> OK

              {
                $aTipoAmbito = $oTipo -> getTipoambito();

                switch ($aTipoAmbito)
                {
                  case "alumno":  // Perfiles alumno y profesor --> se asocia con tabla asignlectivas
                  case "docente":
                    $oAsignlectiva = AsignlectivasPeer::retrieveByPK($idAmbito);

                    if (($oAsignlectiva instanceof Asignlectivas)) // Asignlectiva válida de la Conf. Personal
                    {
                      if ( ($idEA == $oAsignlectiva -> getIdEjercicioacademico()) && ($oAsignlectiva -> getEstado() == 1) )
                      {
                        // OK
                        $out = true;
                      }                      
                    }
                    break;
                  case "cursos":           // Perfil del tutor de curso --> se asocia con tabla usuarios_cursoslec
                    $ousuario_cursolec = UsuariosCursoslecPeer::retrieveByPK($idPersona, $idPerfil, $idAmbito);
                    if (($ousuario_cursolec instanceof UsuariosCursoslec)) // OK
                    {
                        $out = true;
                    }

                    break;
                  case "centros":          // Perfil Secretario --> se asocia con tabla usuario_centro
                    $ousuario_centro = UsuarioCentroPeer::retrieveByPK($idPerfil, $idPersona, $idAmbito);
                    if (($ousuario_centro instanceof UsuarioCentro)) // OK
                    {
                        $out = true;
                    }
                    break;
                  case "contenidos":       // Perfil Autor --> se asocia con tabla usuario_contenido
                    $ousuario_contenido = UsuarioContenidoPeer::retrieveByPK($idPerfil, $idPersona, $idAmbito);
                    if (($ousuario_contenido instanceof UsuarioContenido)) // OK
                    {
                        $out = true;
                    }
                    break;
                  case "uo":               // Perfil Director, Jefe de Estudios, Administrador, ..., etc.  --> se asocia con tabla uos
                    $ou = UosPeer::retrieveByPK($idUO);
                    if (($ou instanceof Uos)) // Es una UO  válida
                    {
                      $out = true;
                    }
                    break;
                  default:
                    $out = false;
                    break;
                }

              }
            }
          } // Está el EA activo

        }  //  EA existe
      }  // if  La UO está OK.
    } // if No hay campos nulos

    return $out;
  }

  protected function dameConfiguracionValida($id_usuario)
  {
    // Inicializamos array de configuracion personal
    
    $tConfPersonal = array();
    $tConfPersonal['id_perfil']    = NULL;
    $tConfPersonal['id_ambito']    = NULL;
    $tConfPersonal['id_uo']        = NULL;
    $tConfPersonal['id_periodo']   = NULL;
    $tConfPersonal['cultura_pref'] = 'esp';  // cultura por defecto.
    $tConfPersonal['marca']        = NULL;
    $tConfPersonal['valida']       = false;
    // Leemos usuarios de la persona que realiza el login
    $c = new Criteria();
    $c -> add(UsuariosPeer::ID_PERSONA, $id_usuario);
    $c -> add(UsuariosPeer::ESTADO, 'ACTIVO');
    $c -> addDescendingOrderByColumn(UsuariosPeer::PORDEFECTO); // Para tomar primero el usuario marcado por defecto
    $c -> addDescendingOrderByColumn(UsuariosPeer::FECHAALTA);  // Después ordenado por fecha de alta. Probamos antes el más reciente.
    $tUsuarios = UsuariosPeer::doSelect($c);

    if (is_array($tUsuarios) && (count($tUsuarios)))  // Si tiene usuarios
    {
      $numUsuarios = count($tUsuarios);
      for ($i = 0, $usuarioValido = false; !$usuarioValido && $i < $numUsuarios; $i++)
      {
        // Seleccionamos al usuario candidato
        $oUsuario = $tUsuarios[$i];
        // Vemos si existe ese perfil
        $oTipo = TiposPeer::retrieveByPK($oUsuario->getIdTipo());
        if (($oTipo instanceof Tipos))
        {
          
          $aTipoAmbito =  $oTipo -> getTipoambito();
          // Comprobamos si existe la UO
          $oUO = UosPeer::retrieveByPK($oTipo->getIdUo());

          if (($oUO instanceof Uos))
          {
            
            $c = new Criteria ();
            $c -> add(EjerciciosacademicosPeer::ID_UO, $oUO -> getId());
            $c -> add(EjerciciosacademicosPeer::ESTADO, 1);
            $c -> addDescendingOrderByColumn(EjerciciosacademicosPeer::ID);
            $oEA = EjerciciosacademicosPeer::doSelectOne($c);

            if (($oEA instanceof Ejerciciosacademicos))
            {
             
              //Según sea el tipo de ámbito de la tabla tipos asociada a este usuario
               switch ($aTipoAmbito)
                {
                  case "alumno":  // Perfiles alumno y profesor --> se asocia con tabla asignlectivas
                    //Obtenemos sus matriculas
                    
                    $tMatriculas = array();
                    $c = new Criteria();
                    $c -> add(MatriculasPeer::ID_PERSONA, $id_usuario);
                    $c -> add(MatriculasPeer::ID_TIPO, $oTipo->getId());
                    $c -> addDescendingOrderByColumn(MatriculasPeer::FECHAREALIZACION);
                    $tMatriculas = MatriculasPeer::doSelect($c);
                    if (is_array($tMatriculas) && count($tMatriculas)) // Si tiene alguna matricula ese usuario alumno
                    {
                      for ($j=0;!$usuarioValido && $j < count($tMatriculas);$j++)
                      {
                        $oMatricula = $tMatriculas[$j];
                        $tAsignlectivas = array();
                        $c = new Criteria();
                        $c -> add(MatriculaAsignaturalectivaPeer::ID_MATRICULA, $oMatricula->getId());

                        $tAsignlectivas = MatriculaAsignaturalectivaPeer::doSelect($c);
                        //Buscamos una asignatura válida de esa matricula
                        if (is_array($tAsignlectivas) && count($tAsignlectivas))
                        {
                          for ($k=0;!$usuarioValido && $k < count($tAsignlectivas);$k++)
                          {
                            $idAL = $tAsignlectivas[$k]->getIdAsignaturalectiva();
                            // Si es una AL del ejerc. Academico actual
                            $oAL = AsignlectivasPeer::retrieveByPK($idAL);
                            if ($oAL instanceof Asignlectivas)
                            {
                              if (($oAL->getIdEjercicioacademico() == $oEA->getId()) && ($oAL->getEstado() == 1))
                              {
                                $usuarioValido=true;
                                
                                $tConfPersonal['id_perfil']    = $oTipo -> getId();
                                $tConfPersonal['id_uo'] = $oUO -> getId();
                                $tConfPersonal['marca'] = $oUO -> getMarca();
                                $tConfPersonal['id_periodo']   = $oEA ->getId();
                                $tConfPersonal['id_ambito']    = $oAL->getId();
                                $tConfPersonal['valida']    = true;
                              }
                            }
                          }  // for ALs
                        }
                      }  // for Matriculas
                    }
                    
                    break;
                  case "docente":
                    $tImparteALs = array();
                    $c = new Criteria();
                    $c -> add(ImpartePeer::ID_PERSONA, $id_usuario);
                    $c -> add(ImpartePeer::ID_TIPO, $oTipo->getId());
                    $c -> add(ImpartePeer::ESTADO, 1);
                    $c -> addDescendingOrderByColumn(ImpartePeer::ID_ASIGNATURALECTIVA);
                    $tImparteALs = ImpartePeer::doSelect($c);
                    //Buscamos una asignatura válida de las que imparte
                    if (is_array($tImparteALs) && count($tImparteALs))
                    {
                      for ($k=0;!$usuarioValido && $k < count($tImparteALs);$k++)
                      {
                        $idAL = $tImparteALs[$k]->getIdAsignaturalectiva();
                        // Si es una AL del ejerc. Academico actual
                        $oAL = AsignlectivasPeer::retrieveByPK($idAL);
                        if ($oAL instanceof Asignlectivas)
                        {
                          if (($oAL->getIdEjercicioacademico() == $oEA->getId()) && ($oAL->getEstado() == 1))
                          {
                            $usuarioValido=true;

                            $tConfPersonal['id_perfil']    = $oTipo -> getId();
                            $tConfPersonal['id_uo'] = $oUO -> getId();
                            $tConfPersonal['marca'] = $oUO -> getMarca();
                            $tConfPersonal['id_periodo']   = $oEA ->getId();
                            $tConfPersonal['id_ambito']    = $oAL->getId();
                            $tConfPersonal['valida']    = true;
                          }
                        }
                      }  // for ALs
                    }

                    break;
                  case "cursos":           // Perfil del tutor de curso --> se asocia con tabla usuarios_cursoslec
                    //Vemos si existe la entrada en usuarios_cursoslec
                    $c = new Criteria();
                    $c -> add (UsuariosCursoslecPeer::ID_PERSONA, $id_usuario);
                    $c -> add (UsuariosCursoslecPeer::ID_TIPO, $oTipo->getId());
                    $c -> add (UsuariosCursoslecPeer::ESTADO, 1);
                    $c -> addDescendingOrderByColumn(UsuariosCursoslecPeer::ID_CURSOLECTIVO);
                    $tUsuariosCursoslec = UsuariosCursoslecPeer::doSelect($c);
                    if (is_array($tUsuariosCursoslec) && (count($tUsuariosCursoslec)))
                    {
                      for ($k=0;!$usuarioValido && $k < count($tUsuariosCursoslec); $k++)
                      {
                        $oUsuarioCursolec = $tUsuariosCursoslec[$k];

                        if ($oUsuarioCursolec instanceof UsuariosCursoslec)
                        {
                          $usuarioValido=true;

                          $tConfPersonal['id_perfil']    = $oTipo -> getId();
                          $tConfPersonal['id_uo'] = $oUO -> getId();
                          $tConfPersonal['marca'] = $oUO -> getMarca();
                          $tConfPersonal['id_periodo']   = $oEA ->getId();
                          $tConfPersonal['id_ambito']    = $oUsuarioCursolec->getIdCursolectivo();
                          $tConfPersonal['valida']    = true;
                        }
                      }
                    }

                    break;
                  case "centros":          // Perfil Secretario --> se asocia con tabla usuario_centro
                    //Vemos si existe la entrada en usuario_centro
                    $c = new Criteria();
                    $c -> add (UsuarioCentroPeer::ID_PERSONA, $id_usuario);
                    $c -> add (UsuarioCentroPeer::ID_TIPO, $oTipo->getId());
                    $tUsuarioCentro = UsuarioCentroPeer::doSelect($c);
                    if (is_array($tUsuarioCentro) && (count($tUsuarioCentro)))
                    {
                      for ($k=0;!$usuarioValido && $k < count($tUsuarioCentro); $k++)
                      {
                        $oUsuarioCentro = $tUsuarioCentro[$k];

                        if ($oUsuarioCentro instanceof UsuarioCentro)
                        {
                          $usuarioValido=true;

                          $tConfPersonal['id_perfil']    = $oTipo -> getId();
                          $tConfPersonal['id_uo'] = $oUO -> getId();
                          $tConfPersonal['marca'] = $oUO -> getMarca();
                          $tConfPersonal['id_periodo']   = $oEA ->getId();
                          $tConfPersonal['id_ambito']    = $oUsuarioCentro->getIdCentro();
                          $tConfPersonal['valida']    = true;
                        }
                      }
                    }
                    break;
                  case "contenidos":       // Perfil Autor --> se asocia con tabla usuario_contenido
                    //Vemos si existe la entrada en usuario_contenido
                    $c = new Criteria();
                    $c -> add (UsuarioContenidoPeer::ID_PERSONA, $id_usuario);
                    $c -> add (UsuarioContenidoPeer::ID_TIPO, $oTipo->getId());
                    $c -> add (UsuarioContenidoPeer::ESTADO, 'ACTIVO');
                    $c -> addDescendingOrderByColumn(UsuarioContenidoPeer::ID_CONTENIDO);
                    $tUsuarioContenido = UsuarioContenidoPeer::doSelect($c);
                    if (is_array($tUsuarioContenido) && (count($tUsuarioContenido)))
                    {
                      for ($k=0;!$usuarioValido && $k < count($tUsuarioContenido); $k++)
                      {
                        $oUsuarioContenido= $tUsuarioContenido[$k];

                        if ($oUsuarioContenido instanceof UsuarioContenido)
                        {
                          $usuarioValido=true;

                          $tConfPersonal['id_perfil']    = $oTipo -> getId();
                          $tConfPersonal['id_uo'] = $oUO -> getId();
                          $tConfPersonal['marca'] = $oUO -> getMarca();
                          $tConfPersonal['id_periodo']   = $oEA ->getId();
                          $tConfPersonal['id_ambito']    = $oUsuarioContenido->getIdContenido();
                          $tConfPersonal['valida']    = true;
                        }
                      }
                    }
                    break;
                  case "uo":               // Perfil Director, Jefe de Estudios, Administrador, ..., etc.  --> se asocia con tabla uos
                    
                    $usuarioValido=true;

                    $tConfPersonal['id_perfil']    = $oTipo -> getId();
                    $tConfPersonal['id_uo'] = $oUO -> getId();
                    $tConfPersonal['marca'] = $oUO -> getMarca();
                    $tConfPersonal['id_periodo']   = $oEA ->getId();
                    $tConfPersonal['id_ambito']    = $oUO -> getId();
                    $tConfPersonal['valida']    = true;
                    break;                 
                }

            }

          }

        }
      } // for Usuarios
    }  // if tiene usuarios

    return $tConfPersonal;
  }

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
    $serv = Servicio::crearServicioUsuario('CVE');
    $out_usuario = $serv -> usuario($in_usuario);
    $usuario = $out_usuario['usuario'];

    $id_usuario = $usuario['identificacion']['edaId']; // Necesito este Id para que el resto funcione

    $tConfPersonal = array();
    $confPersonal  = ConfpersonalesPeer::retrieveByPK($id_usuario);

    if(($confPersonal instanceof Confpersonales) && $this -> comprobarConfiguracionPersonal($confPersonal,$id_usuario))  // Tiene conf. personal y es válida

    {
      $uo = UosPeer::retrieveByPK($confPersonal -> getUoPref());
      $tConfPersonal['id_perfil']    = $confPersonal -> getPerfilPref();
      $tConfPersonal['id_ambito']    = $confPersonal -> getAmbitoPref();
      $tConfPersonal['id_uo']        = $confPersonal -> getUoPref();
      $tConfPersonal['id_periodo']   = $confPersonal -> getEaPref();

      if ($confPersonal -> getIdiomaPref())
      {
        $tConfPersonal['cultura_pref'] = $confPersonal -> getIdiomaPref();
      }
      else  //por defecto español
      {
       $tConfPersonal['cultura_pref'] = 'esp';
      }

      $tConfPersonal['marca']        = $uo -> getMarca();
      $tConfPersonal['valida']       = true;
    }
    else // No dispone de conf. personal o no es válida
    {
      $tConfPersonal = $this -> dameConfiguracionValida($id_usuario);
    }


    if($tConfPersonal['valida'])
    {
      $out['status'] = Servicio::OK;      
    }
    else
    {
       $out['status'] = Servicio::NO_CONTENT;
    }

    $out['configuracion_personal'] = $tConfPersonal;

    return $out;

  }


  protected function dameNombreAmbito($ambito, $tipoAmbito)
  {
    switch ($tipoAmbito)
    {
      case 'cursos':
        $tipoAmbito = new TipoAmbitoCursos($ambito);
        break;
      case 'contenidos':
        $tipoAmbito = new TipoAmbitoContenidos($ambito);
        break;
      case 'alumno':
        $tipoAmbito = new TipoAmbitoAlumno($ambito);
        break;
      case 'docente':
        $tipoAmbito = new TipoAmbitoDocente($ambito);
        break;
      case 'centros':
        $tipoAmbito = new TipoAmbitoCentros($ambito);
        break;
      case 'padres':
        break;
      case 'uo':
        $tipoAmbito = new TipoAmbitoUo($ambito);
        break;
      case 'subordinado':
        break;
    }
    return $tipoAmbito -> dameNombreAmbito($ambito);

  }
}

