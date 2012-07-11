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


class registroActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {

        $this->forward404Unless(sfConfig::get('app_registro_enabled'));
        $this->setLayout('inicio');
        $this->getUser()->setFlash('mensaje', 'Rellena los datos.', false);

        $this->formRegistro = new RegistroForm();
    }

    public function executeEnviarTokenRegistro(sfWebRequest $request) {

        $this->setLayout('inicio');
        $this->formRegistro = new RegistroForm();

        $this->formRegistro->bind($request->getParameter('registro'));

        if ($this->formRegistro->isValid()) {

            $persona = new SftPersona();
            $persona->setNombre($this->formRegistro->getValue('nombre'));
            $persona->setApellido1($this->formRegistro->getValue('apellido1'));
            $persona->setApellido2($this->formRegistro->getValue('apellido2'));
            $persona->save(); //Esto ya crea un eda_usuarios y un sf_guard_user

            $email = new SftEmail();
            $email->setDireccion($this->formRegistro->getValue('direccion'));
            $email->setPredeterminado(1);
            $email->setIdUsuario($persona->dameSftUsuario()->getId());
            $email->save();

            $sfUser = $persona->getSfUser();
            $sfUser->setPassword($this->formRegistro->getValue('password'));
            $sfUser->save();

            $this->enviarTokenRegistro($this->formRegistro->getValue('direccion'));
            $this->redirect('@registro_mensajeEnviado');
        }

        $this->setTemplate('index');
    }

    protected function enviarTokenRegistro($emailTo) {

        //////////////////////////////////////////////
        // buscamos al usuario asociado con el email//
        //////////////////////////////////////////////

        $email = SftEmailPeer::dameEmailConDireccion($this->formRegistro->getValue('direccion'));

        if (!($email instanceof SftEmail)) {
            $this->getUser()->setFlash('error', 'Fallo en el registro, vuelva a intentarlo o contacte con el administrador.');
            return sfView::SUCCESS;
        }

        $edaUsuario = $email->getSftUsuario();
        $sfGuardUser = $edaUsuario->getSfGuardUser();
        $username = $sfGuardUser->getUsername();
        $aplicacion = SftAplicacionPeer::dameAplicacionConClave(sfConfig::get('app_clave'));
        $nombre_aplicacion = $aplicacion->getNombre();

        /////////////////////////////////////////////////////////////////////////////////////////
        // Recojemos el cuerpo y el subject del mensaje desde la configuración de la aplicación//
        /////////////////////////////////////////////////////////////////////////////////////////

        $subject = sfConfig::get('app_registro_mail_subject', 'Registro del sistema symfonite');
        
        $fich_temp = sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'sftRegistroPlugin' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'mensaje.php';
        
        require($fich_temp);
        $body = sfConfig::get('app_registro_mail_body', $body);

        ////////////////////////////////////////////
        // generamos token y construimos el enlace//
        ////////////////////////////////////////////

        $token = Utilidades::generaClave(25);

        sfProjectConfiguration::getActive()->loadHelpers(array('Url'));

        $enlaceToken = url_for('@registro_confirmaRegistro?token=' . $token, true);

        /////////////////////////////////////////////////////////////////////////////
        // insertamos el token en la tabla sf_guard_user y deshabilitamos la cuenta//
        /////////////////////////////////////////////////////////////////////////////

        $sfGuardUser->setTokenResetPassword($token);
        $sfGuardUser->setIsActive(0);
        $sfGuardUser->save();

        ///////////////////////////////////
        // Y, por fin, enviamos el e-mail//
        ///////////////////////////////////
        $from = sfConfig::get('app_registro_mail_from', 'correo-cve@serbal.pntic.mec.es');
        $body .= PHP_EOL . PHP_EOL . $enlaceToken;

        //se crea el transport que usaremos para enviar el correo con los datos del host, puerto, nombre de usuario y pass
        print_r($subject);

        //creacion del mailer usando el transport creado
        $mailer = sfContext::getInstance()->getMailer();

        $result = $mailer->composeAndSend($from, $emailTo, $subject, $body);

        //envio del mail con el metodo send del mailer creado

        if (!$result) {
            echo "Hola, soy un flagrante fallo de envio, QUIEREME!!!! <br/>";
            print_r('$failures');
        }
    }

    public function executeMensajeEnviado(sfWebRequest $request) {
        $this->getUser()->setFlash('mensaje', 'Se ha envíado a tu dirección de correo electrónico un mensaje de confirmación. Sigue las instruciones para completar el registro', false);
    }

    public function executeConfirmaRegistro(sfWebRequest $request) {
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

      
        if ($sfUser instanceof sfGuardUser) {
            $c->clear();
            $c->add(SftUsuarioPeer::ID_SFUSER, $sfUser->getId());

            $edaUsuario = SftUsuarioPeer::doSelectOne($c);
            if (!$edaUsuario instanceof SftUsuario) {
                $this->getUser()->setFlash('error', 'Hemos detectado un error con el siguiente usuario: ' . $sfUser->getUsername() .
                        '. Comuníquelo al administrador de la aplicación');
                return sfView::SUCCESS;
            }


            $this->nombre = $edaUsuario->getNombreCompleto();
            $aplicacion = SftAplicacionPeer::dameAplicacionConClave(sfConfig::get('app_clave'));
//            echo sfConfig::get('app_clave');
//            print_r($aplicacion);
//            exit;
            //Agregarle el perfil de la aplicación (eda_accesos) y crear el usuario de la aplicación (nfg_usuarios)

            $acceso = new SftAcceso();
            $acceso->setIdUsuario($edaUsuario->getId());
            $acceso->setIdPerfil(sfConfig::get('app_id_perfil_inicial'));
            $acceso->setEsinicial(1);
            $acceso->save();

            $confpersonal = new SftConfPersonal();
            $confpersonal->setIdUsuario($edaUsuario->getId());
            $confpersonal->setIdAplicacion($aplicacion->getIdAplicacion());
            $confpersonal->setIdPerfil(sfConfig::get('app_id_perfil_inicial'));
            $confpersonal->setIdPeriodo(sfConfig::get('app_id_periodo_inicial'));
            $confpersonal->save();

            $edaUsuario->setActivo(1);
            $edaUsuario->save();

            $sfUser->setIsActive(1);
            $sfUser->save();
        } else {
            $this->forward404();
        }
    }

}