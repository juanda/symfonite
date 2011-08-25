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

require_once(sfConfig::get('sf_plugins_dir').'/sfGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');

class BaseedaGestorSesionActions extends BasesfGuardAuthActions
{

    public function executeIndex(sfWebRequest $request)
    {
        $aplicacion = EdaAplicacionesPeer::dameAplicacionConClave(sfConfig::get('app_clave'));
        if($aplicacion instanceof EdaAplicaciones)
        {
            if($this -> getUser() -> hasAttribute('id_usuario_from_saml','EDAE3User'))
            {
                $sfUser = SfGuardUserPeer::retrieveByPk(
                                                        $this ->
                                                        getUser()
                                                        -> getAttribute('id_usuario_from_saml',null,'EDAE3User'));
            }
            else
            {
                $token = $this -> getRequest() -> getCookie($aplicacion -> getCodigo().'_inises');

                $sfUser = Utilidades::dameUsuarioConSesionActiva($token, $aplicacion -> getId());
            }
        }
        else
        {
            echo 'La aplicación no está debidamente registrada';
            exit;
        }
        // Si existe sesión activa ejecuta el proceso de inicio de sesión para
        // el usuario
        if($sfUser instanceof sfGuardUser)
        {
            $this->getUser()->signin($sfUser);
            // always redirect to a URL set in app.yml
            // or to the referer
            // or to the homepage
            $signinUrl = sfConfig::get('app_sf_guard_plugin_success_signin_url', $this->getUser()->getReferer('@homepage'));

            return $this->redirect($signinUrl);
        }
        else //Muestra el formulario de login

        {
            parent::executeSignin($request);
            $this -> textoIntro = $aplicacion -> getTextoIntro();
            $this -> setLayout('inicio');
        }
    }

    public function executePerfiles(sfWebRequest $request)
    {

    }


    public function executeCambioDePerfil(sfWebRequest $request)
    {

        $eIdUsuario = $this -> getUser() ->  getAttribute('idUsuario', null, 'EDAE3User');
        $eIdPerfil  = $request -> getParameter('eIdPerfil' );
        $eIdAmbito  = $request -> getParameter('eIdAmbito' );
        $eIdEA      = $request -> getParameter('eIdEa'     );

        //echo $eIdUsuario.",".$eIdPerfil.",".$eIdAmbito.",".$eIdEA;

        $oConfPersonal = new edaConfPersonal($eIdUsuario, $eIdPerfil, $eIdAmbito, $eIdEA);

        if($oConfPersonal -> esValida())
        {
            $this -> getUser() -> resetSesion();
            $this -> getUser() -> construyeSesion($oConfPersonal);

            $this -> redirect('@homepage');
        }
        else
        {
            $this -> redirect('edaGestorErrores/mensajeError?mensaje=Hay algún problema con tu configuración personal');
        }
    }

    public function executeConfiguracionPersonal(sfWebRequest $request)
    {
        //Datos mostrados
        $sfUser = sfGuardUserPeer::retrieveByPK($this -> getUser() -> getAttribute("user_id","","sfGuardSecurityUser"));
        $this->useract = $sfUser -> getUserName();
        $this->userculture = $this->getUser()->getCulture();
        $c = new Criteria();
        $c -> add(EdaCulturasPeer::NOMBRE, $this->userculture );
        $oCultura = EdaCulturasPeer::doSelectOne($c);

        $this->aviso = "";

        //Formularios usados
        //$this->formularioUser      = new EdasfGuardUserForm();
        $this->formularioPass      = new EdasfGuardUserForm();
        $this->formularioUsuarios  = new EdaUsuariosForm();
        if($oCultura instanceof  EdaCulturas)
        {
            $this->userculture = $oCultura->getDescripcion();
            $this -> formularioUsuarios -> setDefault('id_culturapref', $oCultura -> getId());
        }

        //Comprobamos si venimos de un post
        If ($request->isMethod('post'))
        {
            //Modificamos los formularios para que isValid compruebe sólo
            //lo que les corresponde.
            //$this->formularioUser->validarSoloUsuario();
            $this->formularioPass->validarSoloPass();
            $this->formularioUsuarios->validarSoloCultura();

            //comprobamos que formulario se ha enviado y realizamos acciones
            $form = $request->getParameter('form');

            //Obtenemos los datos correspondientes al usuario actual.
            $eIdUsuario = $this->getUser()->getAttribute("idUsuario","","EDAE3User");
            $oUsuario = EdaUsuariosPeer::retrieveByPK($eIdUsuario);
            $oSfUser = sfGuardUserPeer::retrieveByPK($oUsuario->getIdSfuser());
            switch ($form)
            {
                case "login":
                    $array = $request->getParameter('sf_guard_user');
                    $this->formularioUser->bind(array('username' => $array['username']));
                    if ($this->formularioUser->isValid())
                    {
                        //Guardamos en la BD.
                        $oUsuario->setAlias($this->formularioUser->getValue('username'));
                        $oUsuario->save();
                        $oSfUser->setUsername($this->formularioUser->getValue('username'));
                        $oSfUser->save();

                        //Actualizamos la sesion.
                        $sfUser = sfGuardUserPeer::retrieveByPK($this -> getUser() -> getAttribute("user_id","","sfGuardSecurityUser"));
                        $this->useract = $sfUser -> getUserName();
                        $this->aviso="Login cambiado correctamente.";
                    }
                    break;
                case "pass":
                    $array = $request->getParameter('sf_guard_user');
                    $this->formularioPass->bind(array(
                            'password' => $array['password'],'password_again'=> $array['password_again']));
                    if ($this->formularioPass->isValid())
                    {
                        //Guardamos en la BD.
                        $oSfUser->setPassword($this->formularioPass->getValue('password'));
                        $oSfUser->save();
                        $this->aviso="Contraseña cambiada correctamente.";
                    }
                    break;
                case "lang":
                    $array = $request->getParameter('eda_usuarios');
                    $this->formularioUsuarios->bind(array('id_culturapref' => $array['id_culturapref']));
                    if ($this->formularioUsuarios->isValid())
                    {
                        //Guardamos en la BD.
                        $culturaPref = EdaCulturasPeer::retrieveByPK($this->formularioUsuarios->getValue('id_culturapref'));
                        $oUsuario->setIdCulturapref($culturaPref -> getNombre());
                        $oUsuario->save();

                        //Guardamos en la sesión.
                        $this->getUser()->setCulture($culturaPref -> getNombre());
                        $this->userculture = $this->getUser()->getCulture();

                        $this->userculture = $culturaPref->getDescripcion();
                        $this->aviso="Idioma cambiado correctamente.";
                    }
                    break;
                default:
                    break;
            }
        }
    }

    public function executeCambioConfPersonal(sfWebRequest $request)
    {
        $eIdUsuario = $this -> getUser() ->  getAttribute('idUsuario', null, 'EDAE3User');
        $eIdPerfil  = $request -> getParameter('eIdPerfil', null );
        $eIdAmbito  = $request -> getParameter('eIdAmbito', null );
        $eIdEA      = $request -> getParameter('eIdEa', null     );

        //echo $eIdUsuario.",".$eIdPerfil.",".$eIdAmbito.",".$eIdEA;

        $oConfPersonal = new edaConfPersonal($eIdUsuario, $eIdPerfil, $eIdAmbito, $eIdEA);

        if($oConfPersonal -> esValida())
        {
            $usuario = EdaUsuariosPeer::retrieveByPK($eIdUsuario);
            $usuario -> ponConfPersonal($oConfPersonal, sfConfig::get('app_clave'));
        }

        sfConfig::set('sf_web_debug', false);
        return sfView::NONE;

    }

    /**
     * Esta acción muestra todas las aplicaciones que puede utilizar el usuario
     * que está registrado en función de las credenciales que tiene asignadas
     * a través de todos sus perfiles
     *
     */
    public function executeAplicaciones(sfWebRequest $request)
    {
        $in = array(
                'id'     => $this -> getUser() -> getAttribute('idUsuario', null, 'EDAE3User'),
                'tipoId' => 'edaId'
        );

        $serv = Servicio::crearServicioUsuario(sfConfig::get('app_servicio'));
        $out  = $serv -> aplicacionesDelUsuario($in);

        if($out['status'] != Servicio::OK)
        {
            //error
            exit;
        }

        $this  -> aplicaciones = isset($out['aplicaciones'])? $out['aplicaciones'] : null ;
    }


    /**
     *
     * Esta acción redirige a una aplicación pasándole la sesión de la aplicación
     * actual. Para ello se utiliza el mecanismo explicado a continuación:
     *
     * Descripción del mecanismo utilizado para abrir una aplicación en la cual
     * el usuario tiene credenciales, desde otra aplicación en la cual el usuario
     * ya tiene abierta una sesión por que se registró con username y password:
     *
     * Llamaremos a la primera aplicación destino, y a la segunda aplicación origen.
     *
     * La aplicación origen muestra un link que ejecuta la acción executeAbreAplicacion
     * pasándole a dicha acción el id de la aplicación que se desea ejecutar.
     *
     * Esta acción recupera los datos de la aplicación destino correspondiente a dicho id
     * y envía una cookie al cliente que se llama igual que la aplicación destino junto con el
     * sufijo _inises. El valor de este cookie es aleatorio y expira en 60 segundos. Por otra
     * parte almacena un registro en la tabla aplicaciones_sesion con el mismo valor de la
     * cookie la id de la aplicación destino y la id del usuario que ha solicitado abrir la
     * aplicación destino.
     *
     * Una vez hecho esto, la aplicación origen redirige a la aplicación destino.
     *
     * En la aplicación destino el usuario aún no está autentificado, por tanto le pediría el
     * login y el password. Pero esta aplicación , antes de pedir estos datos, comprueba si
     * el cliente le ha enviado una cookie que se llame '{nombreAplicacion}_inises', en cuyo caso
     * busca en la tabla 'aplicaciones_sesion' un registro que tenga como campo 'token' el
     * valor de la cookie y como id_aplicacion el que le corresponda a dicha aplicacion destino.
     * Si existe, significa que ha sido la aplicación origen (con el usuario debidamente identificado)
     * quien ha solicitado su ejecución. Entonces extrae de este mismo registro el id de usuario  e
     * inicia una sesión con este id_usuario sin pedir login/password. Inmediatamente despues de
     * obtener el id_usuario, elimina el registro de la tabla apliaciones_sesion en cuestión.
     *
     * De esa manera, la apliación destino abre una sesión automáticamente (sin introducir login/password).
     *
     */
    public function executeAbreAplicacion(sfWebRequest $request)
    {
        $aplicacion = EdaAplicacionesPeer::retrieveByPK($request -> getParameter('id_aplicacion'));

        $longitud = 15;
        $token = Utilidades::generaClave($longitud);

        $token = substr(md5($token), 0 , $longitud);

        $this->getResponse()->setCookie($aplicacion -> getCodigo().'_inises', $token, time()+20);

        $aplicacion_sesion = new EdaAplicacionSesiones();
        $aplicacion_sesion -> setIdAplicacion($aplicacion -> getId());
        $aplicacion_sesion -> setIdUsuario($this -> getUser() -> getAttribute('idUsuario', null, 'EDAE3User'));
        $aplicacion_sesion -> setToken($token);

        $expira = time() + 20; // se añaden 20 segundos

        $aplicacion_sesion -> setExpira(date('Y-m-d, H:i:s',$expira));
        $aplicacion_sesion -> save();

        $this -> redirect($aplicacion -> getUrl());
    }

    public function executeReinicioPassword(sfWebRequest $request)
    {
        $this -> setLayout('inicio');
        $this -> getUser() -> setFlash('mensaje','Envíanos la dirección de correo que tengas registrada en nuestro sistema y te enviaremos las instrucciones para cambiar la password', false);
        $this -> formReinicioPassword = new ReinicioPasswordForm();
    }

    public function executeEnviarTokenReinicioPassword(sfWebRequest $request)
    {
        $this -> setLayout('inicio');
        $this -> formReinicioPassword = new ReinicioPasswordForm();

        $this -> formReinicioPassword -> bind($request -> getParameter('reiniciopassword'));

        if(! $this -> formReinicioPassword -> isValid())
        {
            $this -> setTemplate('reinicioPassword');
        }
        else
        {
            $this -> enviarTokenReinicioPassword($this -> formReinicioPassword -> getValue('email'));
        }

    }
	
	public function executeRegistro(sfWebRequest $request)
    {
        $this -> setLayout('inicio');
        $this -> getUser() -> setFlash('mensaje','Indica una dirección de correo y un nombre de usuario.', false);
        $this -> formReinicioPassword = new RegistroUsuarioForm();
    }

    public function executeEnviarTokenRegistro(sfWebRequest $request)
    {
        $this -> setLayout('inicio');
        $this -> formReinicioPassword = new RegistroUsuarioForm();

        $this -> formReinicioPassword -> bind($request -> getParameter('registro'));

        if(! $this -> formReinicioPassword -> isValid())
        {
            $this -> setTemplate('registro');
        }
        else
        {
            $this -> enviarTokenRegistro($this -> formReinicioPassword -> getValue('email'));
        }

    }

    public function executeCambiarPassword(sfWebRequest $request)
    {

        $this -> setLayout('inicio');
        $this -> forward404Unless($request -> hasParameter('token')
                || $this -> getUser() -> hasAttribute('id_sfuser','cambioPassword'));

        $this -> showForm = true;
        $c = new Criteria();
        if($request -> hasParameter('token')) //Cambio de password por token

        {
            /////////////////////////////////////////
            // comprobamos que el token está activo//
            /////////////////////////////////////////

            $token = $request -> getParameter('token');

            $c -> add(sfGuardUserPeer::TOKEN_RESET_PASSWORD, $token);
            $this -> queryString = 'token='.$token;
        }
        else // Cambio de password porque ha expirado

        {
            $idSfUser = $this -> getUser() -> getAttribute('id_sfuser',null,'cambioPassword');
            $c -> add(sfGuardUserPeer::ID, $idSfUser);
            $this -> queryString = '';
            $this -> getUser() -> setFlash('mensaje', 'El periodo de validez de su password se ha agotado. Debe cambiarla para poder entrar en el sistema');
        }

        $sfUser = sfGuardUserPeer::doSelectOne($c);

        if($sfUser instanceof sfGuardUser)
        {
            if($this -> getUser() -> hasAttribute('id_sfuser','cambioPassword'));
            {
                // Lo hacemos inactivo para que no pueda entrar
                // hasta que no cambie el password
                $sfUser -> setIsActive(0);
                $sfUser -> save();
            }
            $c -> clear();
            $c -> add(EdaUsuariosPeer::ID_SFUSER, $sfUser -> getId());

            $edaUsuario = EdaUsuariosPeer::doSelectOne($c);
            if(! $edaUsuario instanceof EdaUsuarios)
            {
                $this -> getUser() -> setFlash('error','Hemos detectado un error con el siguiente usuario: '.$sfUser -> getUsername().
                        '. Comuníquelo al administrador de la aplicación');
                return sfView::SUCCESS;
            }

            $this -> nombre = $edaUsuario -> getNombre().' '.$edaUsuario -> getApellido1().' '.$edaUsuario -> getApellido2();
            $this -> formPassword = new EdasfGuardUserForm();

            if($request -> isMethod('post'))
            {
                $this -> forward404Unless($request -> hasParameter('sf_guard_user'));

                $datos = $request->getParameter('sf_guard_user');

                $this -> formPassword -> validarSoloPass();
                $this -> formPassword -> bind(array(
                        'password' => $datos['password'],'password_again'=> $datos['password_again']));

                $passwordHaCambiado = $this -> passwordHaCambiado($datos['password'], $sfUser);
                if($this -> formPassword -> isValid() && $passwordHaCambiado)
                {
                    $sfUser -> setPassword($this -> formPassword -> getValue('password'));
                    $sfUser -> setIsActive(1);
                    $sfUser -> setNumLoginFails(0);
                    $sfUser -> setTokenResetPassword('');
                    if ($this -> getUser() -> hasAttribute('id_sfuser','cambioPassword')) // Si el password había expirado se actualiza la fecha

                    {
                        $sfUser -> setCreatedAt(date('Y-m-d H:i:s'));
                    }
                    $sfUser -> save();

                    $this -> getUser() -> setFlash('mensaje', 'El password se ha cambiado correctamente.', false);
                    $this -> showForm = false;
                    if($this -> getUser() -> hasAttribute('id_sfuser','cambioPassword'))
                    {
                        // Ya ha cambiado el password, le abrimos la sesión y lo dirigimos al inicio
                        $sfUser = sfGuardUserPeer::retrieveByPK($this -> getUser() -> getAttribute('id_sfuser', null, 'cambioPassword' ));
                        $this -> getUser() -> getAttributeHolder('cambioPassword')->remove('id_sfuser');
                        $this -> getUser() -> signIn($sfUser);
                    }
                }
                else if(!$passwordHaCambiado)
                {
                    $this -> getUser() -> setFlash('error', 'El password nuevo debe ser distinto al actual',false);
                }
            }
        }
        else
        {
            $this -> forward404();
        }

    }


    protected function enviarTokenReinicioPassword($emailTo)
    {
        /////////////////////////////////////////////////////////////////////////////////////////
        // Recojemos el cuerpo y el subject del mensaje desde la configuración de la aplicación//
        /////////////////////////////////////////////////////////////////////////////////////////

        $subject = sfConfig::get('app_reinicio_mail_subject','Reinicio del password del sistema symfonite');
        $body = <<< END
Ha solicitado cambiar su password. Pulse en el siguiente enlace para hacerlo.
                
Un Saludo. El equipo de symfonite
END;
        $body    = sfConfig::get('app_reinicio_mail_body',$body);

        //////////////////////////////////////////////
        // buscamos al usuario asociado con el email//
        //////////////////////////////////////////////

        $c = new Criteria();

        $c -> add(EdaEmailsPeer::DIRECCION, $emailTo);
        $c -> add(EdaEmailsPeer::PREDETERMINADO, 1);

        $emailPredeterminado = EdaEmailsPeer::doSelectOne($c);

        if(!$emailPredeterminado instanceof EdaEmails) // El e-mail no está registrado

        {
            $this -> getUser() -> setFlash('error','Esa dirección de e-mail no se corresponde con ningún usuario de nuestro sistema');
            return sfView::SUCCESS;
        }

        ////////////////////////////////////////////////////////////////////////////////////
        // el e-mail está registrado, buscamos el hippie o el organismo que el corresponde//
        ////////////////////////////////////////////////////////////////////////////////////

        $edaUsuario = $emailPredeterminado -> getEdaUsuario();

        $mensajeError = 'Esa dirección de e-mail aún estando registrada en el sistema, no
                    se corresponde con ningún usuario. Comuníque este error al administrador del sistema, por favor. Gracias.';
        if(!$edaUsuario instanceof EdaUsuarios)
        {
            $this -> getUser() -> setFlash('error', $mensajeError);
            return sfView::SUCCESS;
        }

        //////////////////////////////////////////////////////////
        // buscamos el sfGuardUser para cambiarle la contraseña.//
        //////////////////////////////////////////////////////////

        $sfGuardUser = $edaUsuario -> getSfGuardUser();

        if(! $sfGuardUser instanceof sfGuardUser)
        {
            $this -> getUser() -> setFlash('error',$mensajeError);
            return sfView::SUCCESS;
        }

        ////////////////////////////////////////////
        // generamos token y construimos el enlace//
        ////////////////////////////////////////////

        $token = Utilidades::generaClave(25);

        sfProjectConfiguration::getActive()->loadHelpers(array('Url'));

        $enlaceToken = url_for('edaGestorSesion/cambiarPassword?token='.$token);
        $referer = parse_url($this -> getRequest() -> getReferer());

        $enlaceToken = $referer['scheme'].'://'.$referer['host'].$enlaceToken;

        /////////////////////////////////////////////////////////////////////////////
        // insertamos el token en la tabla sf_guard_user y deshabilitamos la cuenta//
        /////////////////////////////////////////////////////////////////////////////

        $sfGuardUser -> setTokenResetPassword($token);
        $sfGuardUser -> setIsActive(0);
        $sfGuardUser -> save();

        ///////////////////////////////////
        // Y, por fin, enviamos el e-mail//
        ///////////////////////////////////

        $body .= PHP_EOL.PHP_EOL.$enlaceToken;

        $mailer = sfContext::getInstance()->getMailer();

        $mailer -> composeAndSend(
                'symfonite@ite.educacion.es',
                $emailTo,
                $subject,
                $body
        );

        $this -> getUser() -> setFlash('mensaje', 'El password ha sido envíado a tu dirección de correo electrónico. Sigue las instruciones para restablecerlo', false);
    }

	protected function enviarTokenRegistro($emailTo)
    {
        /////////////////////////////////////////////////////////////////////////////////////////
        // Recojemos el cuerpo y el subject del mensaje desde la configuración de la aplicación//
        /////////////////////////////////////////////////////////////////////////////////////////

        $subject = sfConfig::get('app_reinicio_mail_subject','Reinicio del password del sistema symfonite');
        $body = <<< END
Ha solicitado cambiar su password. Pulse en el siguiente enlace para hacerlo.
                
Un Saludo. El equipo de symfonite
END;
        $body    = sfConfig::get('app_reinicio_mail_body',$body);

        //////////////////////////////////////////////
        // buscamos al usuario asociado con el email//
        //////////////////////////////////////////////

        $c = new Criteria();

        $c -> add(EdaEmailsPeer::DIRECCION, $emailTo);
        //$c -> add(EdaEmailsPeer::PREDETERMINADO, 1);

        $emailPredeterminado = EdaEmailsPeer::doSelectOne($c);

        if($emailPredeterminado instanceof EdaEmails) // El e-mail ya está registrado
        {
            $this -> getUser() -> setFlash('error','Esa dirección de e-mail ya existe');
            return sfView::SUCCESS;
        }

        //$edaUsuario = $emailPredeterminado -> getEdaUsuario();
        //$sfGuardUser = $edaUsuario -> getSfGuardUser();


        ////////////////////////////////////////////
        // generamos token y construimos el enlace//
        ////////////////////////////////////////////

        $token = Utilidades::generaClave(25);

        sfProjectConfiguration::getActive()->loadHelpers(array('Url'));

        $enlaceToken = url_for('edaGestorSesion/cambiarPassword?token='.$token);
        $referer = parse_url($this -> getRequest() -> getReferer());

        $enlaceToken = $referer['scheme'].'://'.$referer['host'].$enlaceToken;

        /////////////////////////////////////////////////////////////////////////////
        // insertamos el token en la tabla sf_guard_user y deshabilitamos la cuenta//
        /////////////////////////////////////////////////////////////////////////////

        $sfGuardUser -> setTokenResetPassword($token);
        $sfGuardUser -> setIsActive(0);
        $sfGuardUser -> save();

        ///////////////////////////////////
        // Y, por fin, enviamos el e-mail//
        ///////////////////////////////////

        $body .= PHP_EOL.PHP_EOL.$enlaceToken;

        $mailer = sfContext::getInstance()->getMailer();

        $mailer -> composeAndSend(
                'symfonite@ite.educacion.es',
                $emailTo,
                $subject,
                $body
        );

        $this -> getUser() -> setFlash('mensaje', 'El password ha sido envíado a tu dirección de correo electrónico. Sigue las instruciones para restablecerlo', false);
    }

	
    protected function passwordHaCambiado($password, $sfUser)
    {
        $passwordOld = $sfUser -> getPassword();
        $sfUser -> setPassword($password);
        $passwordNew = $sfUser -> getPassword();

        if($passwordNew == $passwordOld)
        {
            return false;
        }
        else
        {
            return true;
        }

    }
    protected function dameConfActual()
    {



        $idUo      = $this  -> getUser() -> getAttribute('idUnidadOrganizativa', null, 'EDAE3User');
        $idPerfil  = $this  -> getUser() -> getAttribute('idPerfil', null, 'EDAE3User');
        $idAmbito  = $this  -> getUser() -> getAttribute('idAmbito', null, 'EDAE3User');
        $idPeriodo = $this  -> getUser() -> getAttribute('idPeriodo', null, 'EDAE3User');

        $confAcual['conf'] = array($idUo, $idPerfil, $idAmbito, $idPeriodo);

        return

                $confAcual;

    }
}
