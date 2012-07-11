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

require_once(sfConfig::get('sf_plugins_dir') . '/sfGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');

class BasesftGestorSesionActions extends BasesfGuardAuthActions
{

    public function executeIndex(sfWebRequest $request)
    {

        // Habilitar el sistema de identidad federada (si no lo está)
        $this->enableSAML();

        $aplicacion = SftAplicacionPeer::dameAplicacionConClave(sfConfig::get('app_clave'));
        switch ($aplicacion->getTipoLogin())
        {
            case 'saml':
                sfConfig::set('sf_login_module', 'sftSAMLSesion');
                break;
            case 'papi':
                sfConfig::set('sf_login_module', 'sftPAPISesion');
                break;                            
        }        

        if ($aplicacion instanceof SftAplicacion)
        {
            if ($this->getUser()->hasAttribute('id_usuario_from_saml', 'SftUser'))
            {
                $sfUser = SfGuardUserPeer::retrieveByPk(
                                $this
                                        ->getUser()
                                        ->getAttribute('id_usuario_from_saml', null, 'SftUser'));
            } else if ($this->getUser()->hasAttribute('id_usuario_from_papi', 'SftUser'))
            {
                $sfUser = SfGuardUserPeer::retrieveByPk(
                                $this
                                        ->getUser()
                                        ->getAttribute('id_usuario_from_papi', null, 'SftUser'));
            } else
            {
                $sfUser = null;
            }
        } else
        {
            echo 'La aplicación no está debidamente registrada';
            exit;
        }
        // Si existe sesión activa ejecuta el proceso de inicio de sesión para
        // el usuario
        if ($sfUser instanceof sfGuardUser)
        {
            $this->getUser()->signin($sfUser);
            // always redirect to a URL set in app.yml
            // or to the referer
            // or to the homepage
            $signinUrl = sfConfig::get('app_sf_guard_plugin_success_signin_url', $this->getUser()->getReferer('@homepage'));

            return $this->redirect($signinUrl);
        } else //Muestra el formulario de login
        {
            parent::executeSignin($request);
            $this->textoIntro = $aplicacion->getTextoIntro();
            $this->setLayout('inicio');
        }
    }

    public function executePerfiles(sfWebRequest $request)
    {
        
    }

    public function executeCambioDePerfil(sfWebRequest $request)
    {

        $eIdUsuario = $this->getUser()->getAttribute('idUsuario', null, 'SftUser');
        $eIdPerfil = $request->getParameter('eIdPerfil');
        $eIdAmbito = $request->getParameter('eIdAmbito');
        $eIdEA = $request->getParameter('eIdEa');

        //echo $eIdUsuario.",".$eIdPerfil.",".$eIdAmbito.",".$eIdEA;

        $oConfPersonal = new sftConfiguracionPersonal($eIdUsuario, $eIdPerfil, $eIdAmbito, $eIdEA);

        if ($oConfPersonal->esValida())
        {
            $this->getUser()->resetSesion();
            $this->getUser()->construyeSesion($oConfPersonal);

            $this->redirect('@homepage');
        } else
        {
            $this->redirect('@sftGuardPlugin_mensajeError?mensaje=Hay algún problema con tu configuración personal');
        }
    }

    public function executeConfiguracionPersonal(sfWebRequest $request)
    {
        //Datos mostrados
        $sfUser = sfGuardUserPeer::retrieveByPK($this->getUser()->getAttribute("user_id", "", "sfGuardSecurityUser"));
        $this->useract = $sfUser->getUserName();
        $this->userculture = $this->getUser()->getCulture();
        $c = new Criteria();
        $c->add(SftCulturaPeer::NOMBRE, $this->userculture);
        $oCultura = SftCulturaPeer::doSelectOne($c);

        $this->aviso = "";

        //Formularios usados
        //$this->formularioUser     = new SftsfGuardUserForm();
        $this->formularioPass = new SftsfGuardUserForm();
        $this->formularioUsuarios = new SftUsuarioForm();

        if ($oCultura instanceof SftCultura)
        {
            $this->userculture = $oCultura->getDescripcion();
            $this->formularioUsuarios->setDefault('id_culturapref', $oCultura->getId());
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
            $eIdUsuario = $this->getUser()->getAttribute("idUsuario", "", "SftUser");
            $oUsuario = SftUsuarioPeer::retrieveByPK($eIdUsuario);
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
                        $sfUser = sfGuardUserPeer::retrieveByPK($this->getUser()->getAttribute("user_id", "", "sfGuardSecurityUser"));
                        $this->useract = $sfUser->getUserName();
                        $this->aviso = "Login cambiado correctamente.";
                    }
                    break;
                case "pass":
                    $array = $request->getParameter('sf_guard_user');
                    $this->formularioPass->bind(array(
                        'password' => $array['password'], 'password_again' => $array['password_again']));
                    if ($this->formularioPass->isValid())
                    {
                        //Guardamos en la BD.
                        $oSfUser->setPassword($this->formularioPass->getValue('password'));
                        $oSfUser->save();
                        $this->aviso = "Contraseña cambiada correctamente.";
                    }
                    break;
                case "lang":
                    $array = $request->getParameter('sft_usuario');
                    $this->formularioUsuarios->bind(array('id_culturapref' => $array['id_culturapref']));
                    if ($this->formularioUsuarios->isValid())
                    {
                        //Guardamos en la BD.                        
                        $culturaPref = SftCulturaPeer::retrieveByPK($this->formularioUsuarios->getValue('id_culturapref'));
                        $oUsuario->setIdCulturapref($culturaPref->getNombre());
                        $oUsuario->save();

                        //Guardamos en la sesión.
                        $this->getUser()->setCulture($culturaPref->getNombre());
                        $this->userculture = $this->getUser()->getCulture();

                        $this->userculture = $culturaPref->getDescripcion();
                        $this->aviso = "Idioma cambiado correctamente.";
                    }
                    break;
                default:
                    break;
            }
        }
    }

    public function executeCambioConfPersonal(sfWebRequest $request)
    {
        $eIdUsuario = $this->getUser()->getAttribute('idUsuario', null, 'SftUser');
        $eIdPerfil = $request->getParameter('eIdPerfil', null);
        $eIdAmbito = $request->getParameter('eIdAmbito', null);
        $eIdEA = $request->getParameter('eIdEa', null);

        //echo $eIdUsuario.",".$eIdPerfil.",".$eIdAmbito.",".$eIdEA;

        $oConfPersonal = new sftConfiguracionPersonal($eIdUsuario, $eIdPerfil, $eIdAmbito, $eIdEA);

        if ($oConfPersonal->esValida())
        {
            $usuario = SftUsuarioPeer::retrieveByPK($eIdUsuario);
            $usuario->ponConfPersonal($oConfPersonal, sfConfig::get('app_clave'));
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
        $id_usuario = $this->getUser()->getAttribute('idUsuario', null, 'SftUser');

        $c = new Criteria();

        $c->add(SftAccesoPeer::ID_USUARIO, $id_usuario);
        $c->addJoin(SftAccesoPeer::ID_PERFIL, SftPerfilCredencialPeer::ID_PERFIL);
        $c->addJoin(SftPerfilCredencialPeer::ID_CREDENCIAL, SftCredencialPeer::ID);
        $c->addJoin(SftCredencialPeer::ID_APLICACION, SftAplicacionPeer::ID);
        $c->setDistinct();

        $tAplicaciones = SftAplicacionPeer::doSelect($c);

        $this->aplicaciones = array();
        $i = 0;
        foreach ($tAplicaciones as $aplicacion)
        {
            $this->aplicaciones[$i]['id'] = $aplicacion->getId();
            $this->aplicaciones[$i]['codigo'] = $aplicacion->getCodigo();
            $this->aplicaciones[$i]['nombre'] = $aplicacion->getNombre();
            $this->aplicaciones[$i]['descripcion'] = $aplicacion->getDescripcion();
            $this->aplicaciones[$i]['logotipo'] = $aplicacion->getLogotipo();
            $this->aplicaciones[$i]['url'] = $aplicacion->getUrl();
            $this->aplicaciones[$i]['url_svn'] = $aplicacion->getUrlSvn();
            $this->aplicaciones[$i]['clave'] = $aplicacion->getClave();
            $this->aplicaciones[$i]['id_credencial'] = $aplicacion->getIdCredencial();
            $i++;
        }
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
        $aplicacion = SftAplicacionPeer::retrieveByPK($request->getParameter('id_aplicacion'));

        $longitud = 15;
        $token = Utilidades::generaClave($longitud);

        $token = substr(md5($token), 0, $longitud);

        $this->getResponse()->setCookie($aplicacion->getCodigo() . '_inises', $token, time() + 20);

        $this->redirect($aplicacion->getUrl());
    }

    public function executeReinicioPassword(sfWebRequest $request)
    {
        $this->setLayout('inicio');
        $this->getUser()->setFlash('mensaje', 'Envíanos la dirección de correo que tengas registrada en nuestro sistema y te enviaremos las instrucciones para cambiar la password', false);
        $this->formReinicioPassword = new ReinicioPasswordForm();
    }

    public function executeEnviarTokenReinicioPassword(sfWebRequest $request)
    {
        $this->setLayout('inicio');
        $this->formReinicioPassword = new ReinicioPasswordForm();

        $this->formReinicioPassword->bind($request->getParameter('reiniciopassword'));

        if (!$this->formReinicioPassword->isValid())
        {
            $this->setTemplate('reinicioPassword');
        } else
        {
            $this->enviarTokenReinicioPassword($this->formReinicioPassword->getValue('email'));
        }
    }

    public function executeRegistro(sfWebRequest $request)
    {
        $this->setLayout('inicio');
        $this->getUser()->setFlash('mensaje', 'Rellena los datos.', false);
        $this->formRegistro = new RegistroUsuarioForm();
    }

    public function executeEnviarTokenRegistro(sfWebRequest $request)
    {
        $this->setLayout('inicio');
        $this->formRegistro = new RegistroUsuarioForm();

        $this->formRegistro->bind($request->getParameter('registro'));

        if (!$this->formRegistro->isValid())
        {
            $this->setTemplate('registro');
        } else
        {
            $con = Propel::getConnection('sft');

            $persona = new SftPersona();
            $persona->setNombre($this->formRegistro->getValue('alias'));
            $persona->save($con); //Esto ya crea un eda_usuarios y un sf_guard_user

            $email = new SftEmail();
            $email->setDireccion($this->formRegistro->getValue('email'));
            $email->setPredeterminado(1);
            $email->setIdUsuario($persona->dameSftUsuario()->getId());
            $email->save($con);

            $sfUser = $persona->getSfUser();
            $sfUser->setUsername($this->formRegistro->getValue('username'));
            $sfUser->setPassword($this->formRegistro->getValue('password'));
            $sfUser->setIsActive(1);
            $sfUser->save($con);

            $usuario = $persona->dameSftUsuario();
            $usuario->setAlias($this->formRegistro->getValue('alias'));
            $usuario->setIdCulturapref('es_ES');
            $usuario->setActivo(1);
            $usuario->save($con);

            $this->enviarTokenRegistro($this->formRegistro->getValue('email'));
        }
    }

    public function executeConfirmaRegistro(sfWebRequest $request)
    {
        $this->setLayout('inicio');
        $this->forward404Unless($request->hasParameter('token'));

        $c = new Criteria();

        /////////////////////////////////////////
        // comprobamos que el token está activo//
        /////////////////////////////////////////

        $token = $request->getParameter('token');

        $c->add(sfGuardUserPeer::TOKEN_RESET_PASSWORD, $token);
        $this->queryString = 'token=' . $token;

        $sfUser = sfGuardUserPeer::doSelectOne($c);

        if ($sfUser instanceof sfGuardUser)
        {
            $c->clear();
            $c->add(SftUsuarioPeer::ID_SFUSER, $sfUser->getId());

            $edaUsuario = SftUsuarioPeer::doSelectOne($c);
            if (!$edaUsuario instanceof SftUsuario)
            {
                $this->getUser()->setFlash('error', 'Hemos detectado un error con el siguiente usuario: ' . $sfUser->getUsername() .
                        '. Comuníquelo al administrador de la aplicación');
                return sfView::SUCCESS;
            }

            $this->nombre = $edaUsuario->getNombre() . ' ' . $edaUsuario->getApellido1() . ' ' . $edaUsuario->getApellido2();

            //Agregarle el perfil de la aplicación (eda_accesos) y crear el usuario de la aplicación (nfg_usuarios)
            $acceso = new SftAcceso();
            $acceso->setIdUsuario($edaUsuario->getId());
            $acceso->setIdPerfil(3);
            $acceso->setEsinicial(1);
            $acceso->save();
            
//            $acceso = new SftAcceso();
//            $acceso->setIdUsuario($edaUsuario->getId());
//            $acceso->setIdPerfil(1);
//            $acceso->save();

            $confpersonal = new SftConfPersonal();
            $confpersonal->setIdUsuario($edaUsuario->getId());
            $confpersonal->setIdAplicacion(2);
            //$confpersonal->setIdPerfil(2);
            $confpersonal->setIdPerfil(3);
            $confpersonal->setIdPeriodo(1);
            $confpersonal->save();

            $usuario_app = new NfgUsuario();
            $usuario_app->setIdSfuser($edaUsuario->getId());
            $usuario_app->save();

            $sfUser->setIsActive(1);
            $sfUser->save();
        } else
        {
            $this->forward404();
        }
    }

    public function executeCambiarPassword(sfWebRequest $request)
    {

        $this->setLayout('inicio');
        $this->forward404Unless($request->hasParameter('token')
                || $this->getUser()->hasAttribute('id_sfuser', 'cambioPassword'));

        $this->showForm = true;
        $c = new Criteria();
        if ($request->hasParameter('token')) //Cambio de password por token
        {
            /////////////////////////////////////////
            // comprobamos que el token está activo//
            /////////////////////////////////////////

            $token = $request->getParameter('token');

            $c->add(sfGuardUserPeer::TOKEN_RESET_PASSWORD, $token);
            $this->queryString = 'token=' . $token;
        } else // Cambio de password porque ha expirado
        {
            $idSfUser = $this->getUser()->getAttribute('id_sfuser', null, 'cambioPassword');
            $c->add(sfGuardUserPeer::ID, $idSfUser);
            $this->queryString = '';
            $this->getUser()->setFlash('mensaje', 'El periodo de validez de su password se ha agotado. Debe cambiarla para poder entrar en el sistema');
        }

        $sfUser = sfGuardUserPeer::doSelectOne($c);

        if ($sfUser instanceof sfGuardUser)
        {
            if ($this->getUser()->hasAttribute('id_sfuser', 'cambioPassword'))
                ;
            {
                // Lo hacemos inactivo para que no pueda entrar
                // hasta que no cambie el password
                $sfUser->setIsActive(0);
                $sfUser->save();
            }
            $c->clear();
            $c->add(SftUsuarioPeer::ID_SFUSER, $sfUser->getId());

            $edaUsuario = SftUsuarioPeer::doSelectOne($c);
            if (!$edaUsuario instanceof SftUsuario)
            {
                $this->getUser()->setFlash('error', 'Hemos detectado un error con el siguiente usuario: ' . $sfUser->getUsername() .
                        '. Comuníquelo al administrador de la aplicación');
                return sfView::SUCCESS;
            }

            $this->nombre = $edaUsuario->getNombre() . ' ' . $edaUsuario->getApellido1() . ' ' . $edaUsuario->getApellido2();
            $this->formPassword = new SftsfGuardUserForm();

            if ($request->isMethod('post'))
            {
                $this->forward404Unless($request->hasParameter('sf_guard_user'));

                $datos = $request->getParameter('sf_guard_user');

                $this->formPassword->validarSoloPass();
                $this->formPassword->bind(array(
                    'password' => $datos['password'], 'password_again' => $datos['password_again']));

                $passwordHaCambiado = $this->passwordHaCambiado($datos['password'], $sfUser);
                if ($this->formPassword->isValid() && $passwordHaCambiado)
                {
                    $sfUser->setPassword($this->formPassword->getValue('password'));
                    $sfUser->setIsActive(1);
                    $sfUser->setNumLoginFails(0);
                    $sfUser->setTokenResetPassword('');
                    if ($this->getUser()->hasAttribute('id_sfuser', 'cambioPassword')) // Si el password había expirado se actualiza la fecha
                    {
                        $sftUser = $this->getUser()->getSftUsuario();
                        $sftUser->setUpdatedAt(date('Y-m-d H:i:s'));
                        $sftUser->save();
                    }
                    $sfUser->save();

                    $this->getUser()->setFlash('mensaje', 'El password se ha cambiado correctamente.', false);
                    $this->showForm = false;
                    if ($this->getUser()->hasAttribute('id_sfuser', 'cambioPassword'))
                    {
                        // Ya ha cambiado el password, le abrimos la sesión y lo dirigimos al inicio
                        $sfUser = sfGuardUserPeer::retrieveByPK($this->getUser()->getAttribute('id_sfuser', null, 'cambioPassword'));
                        $this->getUser()->getAttributeHolder('cambioPassword')->remove('id_sfuser');
                        $this->getUser()->signIn($sfUser);
                    }
                } else if (!$passwordHaCambiado)
                {
                    $this->getUser()->setFlash('error', 'El password nuevo debe ser distinto al actual', false);
                }
            }
        } else
        {
            $this->forward404();
        }
    }

    protected function enviarTokenReinicioPassword($emailTo)
    {
        /////////////////////////////////////////////////////////////////////////////////////////
        // Recojemos el cuerpo y el subject del mensaje desde la configuración de la aplicación//
        /////////////////////////////////////////////////////////////////////////////////////////

        $subject = sfConfig::get('app_reinicio_mail_subject', 'Reinicio del password del sistema symfonite');
        $body = <<< END
Ha solicitado cambiar su password. Pulse en el siguiente enlace para hacerlo.
                
Un Saludo. El equipo de symfonite
END;
        $body = sfConfig::get('app_reinicio_mail_body', $body);

        //////////////////////////////////////////////
        // buscamos al usuario asociado con el email//
        //////////////////////////////////////////////

        $c = new Criteria();

        $c->add(SftEmailPeer::DIRECCION, $emailTo);
        $c->add(SftEmailPeer::PREDETERMINADO, 1);

        $emailPredeterminado = SftEmailPeer::doSelectOne($c);

        if (!$emailPredeterminado instanceof SftEmail) // El e-mail no está registrado
        {
            $this->getUser()->setFlash('error', 'Esa dirección de e-mail no se corresponde con ningún usuario de nuestro sistema');
            return sfView::SUCCESS;
        }

        ////////////////////////////////////////////////////////////////////////////////////
        // el e-mail está registrado, buscamos el hippie o el organismo que el corresponde//
        ////////////////////////////////////////////////////////////////////////////////////

        $edaUsuario = $emailPredeterminado->getSftUsuario();

        $mensajeError = 'Esa dirección de e-mail aún estando registrada en el sistema, no
                    se corresponde con ningún usuario. Comuníque este error al administrador del sistema, por favor. Gracias.';
        if (!$edaUsuario instanceof SftUsuario)
        {
            $this->getUser()->setFlash('error', $mensajeError);
            return sfView::SUCCESS;
        }

        //////////////////////////////////////////////////////////
        // buscamos el sfGuardUser para cambiarle la contraseña.//
        //////////////////////////////////////////////////////////

        $sfGuardUser = $edaUsuario->getSfGuardUser();

        if (!$sfGuardUser instanceof sfGuardUser)
        {
            $this->getUser()->setFlash('error', $mensajeError);
            return sfView::SUCCESS;
        }

        ////////////////////////////////////////////
        // generamos token y construimos el enlace//
        ////////////////////////////////////////////

        $token = Utilidades::generaClave(25);

        sfProjectConfiguration::getActive()->loadHelpers(array('Url'));

        $enlaceToken = url_for('@sftGuardPlugin_cambiarPasswordToken?token=' . $token);
        $referer = parse_url($this->getRequest()->getReferer());

        $enlaceToken = $referer['scheme'] . '://' . $referer['host'] . $enlaceToken;

        /////////////////////////////////////////////////////////////////////////////
        // insertamos el token en la tabla sf_guard_user y deshabilitamos la cuenta//
        /////////////////////////////////////////////////////////////////////////////

        $sfGuardUser->setTokenResetPassword($token);
        $sfGuardUser->setIsActive(0);
        $sfGuardUser->save();

        ///////////////////////////////////
        // Y, por fin, enviamos el e-mail//
        ///////////////////////////////////

        $body .= PHP_EOL . PHP_EOL . $enlaceToken;

        $mailer = sfContext::getInstance()->getMailer();

        $mailer->composeAndSend(
                'no-reply@symfonite.es', $emailTo, $subject, $body
        );

        $this->getUser()->setFlash('mensaje', 'El password ha sido envíado a tu dirección de correo electrónico. Sigue las instruciones para restablecerlo', false);
    }

    protected function enviarTokenRegistro($emailTo)
    {
        /////////////////////////////////////////////////////////////////////////////////////////
        // Recojemos el cuerpo y el subject del mensaje desde la configuración de la aplicación//
        /////////////////////////////////////////////////////////////////////////////////////////

        $subject = sfConfig::get('app_registro_mail_subject', 'Registro del sistema symfonite');
        $body = <<< END
Ha solicitado darse de alta en el sistema symfonite. Pulse en el siguiente enlace para completar el registro.
                
Un Saludo. El equipo de symfonite
END;
        $body = sfConfig::get('app_registro_mail_body', $body);

        //////////////////////////////////////////////
        // buscamos al usuario asociado con el email//
        //////////////////////////////////////////////

        $c = new Criteria();

        $c->add(SftEmailPeer::DIRECCION, $emailTo);
        //$c -> add(SftEmailPeer::PREDETERMINADO, 1);

        $emailPredeterminado = SftEmailPeer::doSelectOne($c);

        if (!$emailPredeterminado instanceof SftEmail) // El e-mail no está registrado
        {
            $this->getUser()->setFlash('error', 'Fallo en el registro, vuelva a intentarlo o contacte con el administrador.');
            return sfView::SUCCESS;
        }


        $edaUsuario = $emailPredeterminado->getSftUsuario();
        $sfGuardUser = $edaUsuario->getSfGuardUser();


        ////////////////////////////////////////////
        // generamos token y construimos el enlace//
        ////////////////////////////////////////////

        $token = Utilidades::generaClave(25);

        sfProjectConfiguration::getActive()->loadHelpers(array('Url'));

        $enlaceToken = url_for('@sftGuardPlugin_confirmaRegistroToken?token=' . $token, true);
        //$referer = parse_url($this -> getRequest() -> getReferer());
        //$enlaceToken = $referer['scheme'].'://'.$referer['host'].$enlaceToken;
        /////////////////////////////////////////////////////////////////////////////
        // insertamos el token en la tabla sf_guard_user y deshabilitamos la cuenta//
        /////////////////////////////////////////////////////////////////////////////

        $sfGuardUser->setTokenResetPassword($token);
        $sfGuardUser->setIsActive(0);
        $sfGuardUser->save();

        ///////////////////////////////////
        // Y, por fin, enviamos el e-mail//
        ///////////////////////////////////
        $from = sfConfig::get('app_registro_mail_from', 'symfonite@ite.educacion.es');
        $body .= PHP_EOL . PHP_EOL . $enlaceToken;

        $mailer = sfContext::getInstance()->getMailer();

        $mailer->composeAndSend($from, $emailTo, $subject, $body);

        $this->getUser()->setFlash('mensaje', 'Se ha envíado a tu dirección de correo electrónico un mensaje de confirmación. Sigue las instruciones para completar el registro', false);
    }

    protected function passwordHaCambiado($password, $sfUser)
    {
        $passwordOld = $sfUser->getPassword();
        $sfUser->setPassword($password);
        $passwordNew = $sfUser->getPassword();

        if ($passwordNew == $passwordOld)
        {
            return false;
        } else
        {
            return true;
        }
    }

    protected function dameConfActual()
    {
        $idUo = $this->getUser()->getAttribute('idUnidadOrganizativa', null, 'SftUser');
        $idPerfil = $this->getUser()->getAttribute('idPerfil', null, 'SftUser');
        $idAmbito = $this->getUser()->getAttribute('idAmbito', null, 'SftUser');
        $idPeriodo = $this->getUser()->getAttribute('idPeriodo', null, 'SftUser');

        $confAcual['conf'] = array($idUo, $idPerfil, $idAmbito, $idPeriodo);

        return

                $confAcual;
    }

    // Para habilitar el framework simpleSAMLphp y configurarlo correctamente sin
    // tener que tocar los ficheros de configuración manualmente. Hay que conocer
    // previamente la url relativa base donde dicho framework está instalado.
    // Este dato no se sabe hasta que la aplicación se ejecuta a través de una
    // petición HTTP. Por eso la configuración del simpleSAMLphp se realiza en este
    // momento (una vez ejecutada la aplicación)
    protected function enableSAML()
    {
        // Si ya está habilitado el sistema de identidad federada SAML no se hace nada        
        if (file_exists(dirname(__FILE__) . '/../../../../sftSAMLPlugin/lib/vendor/simplesamlphp-1.8.0-rc1/metadata/.saml_enabled'))
        {
            $this->enabledSAMLSuccess = true;
            return;
        }

        $this->config = dirname(__FILE__) . '/../../../../sftSAMLPlugin/lib/vendor/simplesamlphp-1.8.0-rc1/config/config.php';
        $this->sp_remote = dirname(__FILE__) . '/../../../../sftSAMLPlugin/lib/vendor/simplesamlphp-1.8.0-rc1/metadata/saml20-sp-remote.php';
        $this->idp_remote = dirname(__FILE__) . '/../../../../sftSAMLPlugin/lib/vendor/simplesamlphp-1.8.0-rc1/metadata/saml20-idp-remote.php';
        $this->metadata = dirname(__FILE__) . '/../../../../sftSAMLPlugin/lib/vendor/simplesamlphp-1.8.0-rc1/metadata';

        if (
                is_writable($this->config) &&
                is_writable($this->metadata) &&
                is_writable($this->idp_remote) &&
                is_writable($this->sp_remote)
        )
        {
            $request = sfContext::getInstance()->getRequest();

            $protocol = ($request->isSecure()) ? 'https://' : 'http://';

            $simplesamlRelUrl = $request->getRelativeUrlRoot() . '/simplesaml/';
            $simplesamlAbsUrl = $protocol . $request->getHost() . $simplesamlRelUrl;

            $fs = new sfFilesystem();

            $files = array($this->config, $this->sp_remote, $this->idp_remote);
            $tokens = array(
                'BASEURLPATH' => substr($simplesamlRelUrl, 1),
                'ABSOLUTEROOTURL' => $simplesamlAbsUrl);
            $fs->replaceTokens($files, '%%', '%%', $tokens);
            $fs->touch(dirname(__FILE__) . '/../../../../sftSAMLPlugin/lib/vendor/simplesamlphp-1.8.0-rc1/metadata/.saml_enabled');

            $this->enabledSAMLSuccess = true;
        } else
        {
            $this->enabledSAMLSuccess = false;
        }
    }

}
