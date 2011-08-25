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

class edaGestorSesionComponents extends sfComponents
{
    public function executeCompLogin()
    {
        $this -> conTablas = true;
        // antes de ofrecer  la pantalla de login, comprobamos que la
        // aplicación esté debidamente registrada
        $claveAplicacion = sfConfig::get('app_clave');
        $this -> muestraFormLogin = true;
        $in  = array('clave' => $claveAplicacion);
        $serv = Servicio::crearServicioAplicaciones(sfConfig::get('app_servicio'));
        $out = $serv -> autorizacion($in);
        if($out['status'] != Servicio::ACCEPTED) //la aplicación no está autorizada

        {
            $this -> getUser() -> setFlash('mensaje', 'Aplicación no registrada ');
            $this -> muestraFormLogin = false;
        }

        $this -> form = new sfGuardFormSignin();
        if($this -> getRequest() -> hasParameter('signin'))
        {
            $this -> form -> bind($this -> getRequest() -> getParameter('signin'));
        }
        $this -> form -> addCSRFProtection();
    }

    public function executeCompUsuario()
    {
        $idUsuario = $this -> getUser() -> getAttribute('idUsuario', null, 'EDAE3User');
        $idPerfil  = $this -> getUser() -> getAttribute('idPerfil', null, 'EDAE3User');
        $idAmbito  = $this -> getUser() -> getAttribute('idAmbito', null, 'EDAE3User');
        $idPeriodo = $this -> getUser() -> getAttribute('idPeriodo', null, 'EDAE3User');

        // Pillamos el usuario
        if(isset ($idUsuario))
        {

            $in = array('id' => $idUsuario, 'tipoId' => 'edaId' );
            $serv = Servicio::crearServicioUsuario(sfConfig::get('app_servicio'));
            $out = $serv -> usuario($in);
            if($out['status'] != Servicio::OK)
            {
                $this  -> getUser() -> setFlash('errorServicio', 'Error (usuario) '.$out['status'].' - '.Servicio::mensajeError($out['status']));
                return;
            }
            $usuario = $out['usuario'];

            if($usuario['tipo'] == 'persona')
            {
                $this -> nombre = $usuario['nombre']. ' '. $usuario['apellido1'].' '.$usuario['apellido2'];
            }
            else
            {
                $this -> nombre = $usuario['nombre'];
            }
        }

        if(isset ($idPerfil))
        {
            $in = array('id' => $idPerfil);
            $serv = Servicio::crearServicioEstructuraOrganizativa(sfConfig::get('app_servicio'));
            $out = $serv -> perfil($in);

            if($out['status'] != Servicio::OK)
            {
                $this  -> getUser() -> setFlash('mensaje', 'Error (perfil) '.$out['status'].' - '.Servicio::mensajeError($out['status']));
                return;
            }
            $perfil = $out['perfil'];

            $this -> perfil = $perfil['nombre'];
            $this -> uo     = $perfil['uo']['nombre'];


            if(isset($idAmbito))
            {
                $in = array('id' => $idAmbito, 'ambito' => $perfil['ambitotipo']);
                $serv = Servicio::crearServicioEstructuraOrganizativa(sfConfig::get('app_servicio'));
                $out = $serv -> ambito($in);

                if($out['status'] != Servicio::OK)
                {
                    $this  -> getUser() -> setFlash('mensaje', 'Error (Ambito) '.$out['status'].' - '.Servicio::mensajeError($out['status']));
                    return;
                }
                $ambito = $out['ambito'];

                $this -> ambito = $ambito['nombre'];
            }

        }

        if(isset($idPeriodo))
        {
            $in = array('id' => $idPeriodo);
            $serv = Servicio::crearServicioEstructuraOrganizativa(sfConfig::get('app_servicio'));
            $out = $serv -> periodo($in);
            if($out['status'] != Servicio::OK)
            {
                $this  -> getUser() -> setFlash('mensaje', 'Error (periodo) '.$out['status'].' - '.Servicio::mensajeError($out['status']));
                return;
            }
            $periodo = $out['periodo'];

            if(!$periodo['unico'])
                $this -> periodo  = $periodo['descripcion'];
        }

    }

    public function executeCompMenuGeneral()
    {       
        $this -> linkPerfiles              = (sfConfig::get('app_menu_general_perfiles'))?              url_for('edaGestorSesion/perfiles') : null;
        $this -> linkConfiguracionPersonal = (sfConfig::get('app_menu_general_configuracionPersonal'))? url_for('edaGestorSesion/configuracionPersonal') : null;
        $this -> linkAplicaciones          = (sfConfig::get('app_menu_general_aplicaciones'))?          url_for('edaGestorSesion/aplicaciones') : null;
        $this -> linkAyuda                 = (sfConfig::get('app_menu_general_ayuda'))?                 url_for('gestorAyuda/ver?modulo=general&pagina=index'.'.'.$this -> getUser()->getCulture()) : null;
        $this -> linkDesconectar           = (sfConfig::get('app_menu_general_desconectar'))?           url_for('edaGestorSesion/signout') : null;
    }

    public function executeCompMenu()
    {
        if(!$this -> getUser() -> hasAttribute('idPerfil', 'EDAE3User'))
        {
            return sfView::NONE;
        }
        $in = array('id' => $this -> getUser() -> getAttribute('idPerfil', null, 'EDAE3User'));
        $serv = Servicio::crearServicioEstructuraOrganizativa(sfConfig::get('app_servicio'));
        $out  = $serv -> perfil($in);
        if($out['status'] != Servicio::OK)
        {
            sfContext::getInstance() -> getController() -> getAction() -> redirect('edaGestorErrores/mensajeError?mensaje=Error '.$out['status'].' - '.Servicio::mensajeError($out['status']));
        }
        $nombreMenu = $out['perfil']['menu'];


        if(file_exists(sfConfig::get('sf_app_config_dir').'/menus/'.$nombreMenu))
        {
            $this -> menus = sfYaml::load(sfConfig::get('sf_app_config_dir').'/menus/'.$nombreMenu);
        }

    }

    public function executeCompPerfiles()
    {
        $claveAplicacion = sfConfig::get('app_clave');

        // Comprobamos que la apliación está autorizada
        $in  = array('clave' => $claveAplicacion);
        $serv = Servicio::crearServicioAplicaciones(sfConfig::get('app_servicio'));
        $out = $serv -> autorizacion($in);
        if($out['status'] != '202') //la aplicación no está autorizada

        {
            sfContext::getInstance() -> getController -> redirect('edaGestorErrores/mensajeError?mensaje=Error '.$out['status'].' - '.Servicio::mensajeError($out['status']));
        }

        // Pillamos los ejercicios academicos activos donde tiene perfiles activos el usuario
        // Pillamos el usuario
        $idUsuario = $this -> getUser() -> getAttribute('idUsuario', null, 'EDAE3User');

        $in = array('id' => $idUsuario, 'tipoId' => 'edaId', 'clave_aplicacion' => $claveAplicacion);
        $serv = Servicio::crearServicioUsuario(sfConfig::get('app_servicio'));
        $out = $serv -> perfilesDelUsuarioEnAplicacion($in);

        if($out['status'] == Servicio::NO_CONTENT)
        {
            $this -> getUser() -> signOut(); // Para que borre lo que hasta este momento lleva de sesión (la parte de identificación)
            $this -> getUser() -> setFlash('mensaje', 'El usuario no tiene perfiles en esta aplicación');

        }

        if($out['status'] != Servicio::OK)
        {
            sfContext::getInstance() ->  getController() -> redirect('edaGestorErrores/mensajeError?mensaje=Error '.$out['status'].' - '.Servicio::mensajeError($out['status']));
        }

        $this -> tInfoPerfiles = $out['perfiles'];

        $choices = array();
        foreach($this -> tInfoPerfiles as $ea)
        {
            $choices[$ea['nombre_uo']]= array();
            foreach($ea['perfiles'] as $perfil)
            {
                $choices[$ea['nombre_uo']][$perfil['nombre_perfil']]= array();
                foreach($perfil['ambitos'] as $ambito)
                {
                    if($ambito['nombre'] == 'no_ambitos')
                    {
                        $choices[$ea['nombre_uo']][$perfil['nombre_perfil']][] = 'entrar';
                    }
                    elseif($ambito['nombre'] == 'porasociar')
                    {
                        $choices[$ea['nombre_uo']][$perfil['nombre_perfil']][] = 'el perfil no tiene ámbitos asociados';
                    }
                    else
                    {
                        $choices[$ea['nombre_uo']][$perfil['nombre_perfil']][] = $ambito['nombre'];
                    }
                }
            }
        }


        $usuario = EdaUsuariosPeer::retrieveByPK($idUsuario);
        $this -> confPersonal = $usuario -> dameConfPersonal($claveAplicacion);
        //$this -> w = new sfWidgetFormChoice(array('choices' => $choices, 'expanded' => false, 'multiple' => true));

//        echo '<pre>';
//        print_r($this -> confActual);
//        echo '</pre>';
//        exit;
    }

    public function executeMenu()
    {
        if($this -> getUser() instanceof Usuario)
        {
            // NO IMPLEMENTADO AÚN
            // Hay que construir el menú
        }
    }

    public function executeCSS()
    {
        if($this -> getUser() instanceof Usuario)
        {
            // NO IMPLEMENTADO AÚN
            // Hay que buscar las css's
        }

        $this -> tCss =  array('default.css', 'admin.css', 'menu.css');
    }
}

?>
