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

class sftGestorSesionComponents extends sfComponents
{

    public function executeCompLogin()
    {
        // antes de ofrecer  la pantalla de login, comprobamos que la
        // aplicación esté debidamente registrada
        $clave = sfConfig::get('app_clave');
        $this->muestraFormLogin = true;
        $aplicacion = SftAplicacionPeer::dameAplicacionConClave($clave);
        sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');

        if (!$aplicacion instanceof SftAplicacion) //la aplicación no está autorizada
        {
            $this->getUser()->setFlash('mensaje', __('Aplicación no registrada '));
            $this->muestraFormLogin = false;
        }

        $this->form = new sfGuardFormSignin();
        if ($this->getRequest()->hasParameter('signin'))
        {
            $this->form->bind($this->getRequest()->getParameter('signin'));
        }
        $this->form->addCSRFProtection();
    }

    public function executeCompUsuario()
    {
        $idUsuario = $this->getUser()->getAttribute('idUsuario', null, 'SftUser');
        $idPerfil = $this->getUser()->getAttribute('idPerfil', null, 'SftUser');
        $idAmbito = $this->getUser()->getAttribute('idAmbito', null, 'SftUser');
        $idPeriodo = $this->getUser()->getAttribute('idPeriodo', null, 'SftUser');
        sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');

        // Pillamos el usuario
        if (isset($idUsuario))
        {
            $usuario = SftUsuarioPeer::retrieveByPK($idUsuario);

            if ($usuario->esPersona())
            {
                $this->nombre = $usuario->NombreCompleto();
            } else
            {
                $this->nombre = $usuario->getNombre();
            }
        }

        if (isset($idPerfil))
        {
            $perfil = SftPerfilPeer::retrieveByPK($idPerfil);

            if (!$perfil instanceof SftPerfil)
            {
                throw new Exception(__('Perfil inexistente'));
            }


            $this->perfil = $perfil->getNombre();
            $this->uo = $perfil->getSftUo()->getNombre();


            if (isset($idAmbito))
            {
                $ambito = SftAmbitoPeer::retrieveByPK($idAmbito);

                if (!$ambito instanceof SftAmbito)
                {
                    throw new Exception(__('Ámbito inexistente'));
                }

                $this->ambito = $ambito->getNombre();
            }
        }

        if (isset($idPeriodo))
        {
            $periodo = SftPeriodoPeer::retrieveByPK($idPeriodo);

            if (!$periodo instanceof SftPeriodo)
            {
                throw new Exception(__('Periodo inexistente'));
            }

            $periodos = $periodo->getSftUo()->getSftPeriodos();

            if (count($periodos) != 1)
                $this->periodo = $periodo->getDescripcion();
        }
    }

    public function executeCompMenuGeneral()
    {
        $this->linkPerfiles = (sfConfig::get('app_menu_general_perfiles')) ? url_for('sftGestorSesion/perfiles') : null;
        $this->linkConfiguracionPersonal = (sfConfig::get('app_menu_general_configuracionPersonal')) ? url_for('sftGestorSesion/configuracionPersonal') : null;
        $this->linkAplicaciones = (sfConfig::get('app_menu_general_aplicaciones')) ? url_for('sftGestorSesion/aplicaciones') : null;
        $this->linkAyuda = (sfConfig::get('app_menu_general_ayuda')) ? $this->linkAyuda() : null;

        $aplicacion = SftAplicacionPeer::dameAplicacionConClave(sfConfig::get('app_clave'));
        if ($aplicacion instanceof SftAplicacion)
        {
            switch ($aplicacion->getTipoLogin())
            {                
                case 'saml':
                    $linkLogout = url_for('sftSAMLSesion/logout');
                    break;
                default:
                    $linkLogout = url_for('sftGestorSesion/signout');
                    break;
            }
        }

        $this->linkDesconectar = (sfConfig::get('app_menu_general_desconectar')) ? $linkLogout : null;
    }

    public function executeCompMenu()
    {
        if(!$this -> getUser() -> hasAttribute('idPerfil', 'SftUser'))
        {
            return sfView::NONE;
        }
                
        $perfil = SftPerfilPeer::retrieveByPK($this -> getUser() -> getAttribute('idPerfil',null,'SftUser'));
        $nombreMenu = $perfil->getMenu();

        if(file_exists(sfConfig::get('sf_app_config_dir').'/menus/'.$nombreMenu))
        {
            $this -> menus = sfYaml::load(sfConfig::get('sf_app_config_dir').'/menus/'.$nombreMenu);
        }

    }
    
    public function executeCompPerfiles()
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');

        $clave = sfConfig::get('app_clave');

        $aplicacion = SftAplicacionPeer::dameAplicacionConClave($clave);

        // Comprobamos que la apliación está autorizada

        if (!$aplicacion instanceof SftAplicacion) //la aplicación no está autorizada
        {
            $mensaje = __('La aplicación no está debidamente registrada');
            sfContext::getInstance()->getController->redirect('sftGestorErrores/mensajeError?mensaje=' . $mensaje);
        }

        // Pillamos los ejercicios academicos activos donde tiene perfiles activos el usuario
        // Pillamos el usuario
        $idUsuario = $this->getUser()->getAttribute('idUsuario', null, 'SftUser');

        $usuario = SftUsuarioPeer::retrieveByPK($idUsuario);
        $this->tInfoPerfiles = $usuario->getPerfilesEnAplicacion($aplicacion->getId());

        if (count($this->tInfoPerfiles) == 0)
        {
            $this->getUser()->signOut(); // Para que borre lo que hasta este momento lleva de sesión (la parte de identificación)
            $this->getUser()->setFlash('mensaje', __('El usuario no tiene perfiles en esta aplicación'));
            $current_action = sfContext::getInstance()->getActionStack()->getLastEntry()->getActionInstance();
            $current_action->redirect('@login');
        }

        $choices = array();
        foreach ($this->tInfoPerfiles as $ea)
        {
            $choices[$ea['nombre_uo']] = array();
            foreach ($ea['perfiles'] as $perfil)
            {
                $choices[$ea['nombre_uo']][$perfil['nombre_perfil']] = array();
                foreach ($perfil['ambitos'] as $ambito)
                {
                    if ($ambito['nombre'] == 'no_ambitos')
                    {
                        $choices[$ea['nombre_uo']][$perfil['nombre_perfil']][] = 'entrar';
                    } elseif ($ambito['nombre'] == 'porasociar')
                    {
                        $choices[$ea['nombre_uo']][$perfil['nombre_perfil']][] = 'el perfil no tiene ámbitos asociados';
                    } else
                    {
                        $choices[$ea['nombre_uo']][$perfil['nombre_perfil']][] = $ambito['nombre'];
                    }
                }
            }
        }

        $this->confPersonal = $usuario->dameConfPersonal($clave);
    }

    public function executeMenu()
    {
        if ($this->getUser() instanceof Usuario)
        {
            // NO IMPLEMENTADO AÚN
            // Hay que construir el menú
        }
    }

    public function executeCSS()
    {
        if ($this->getUser() instanceof Usuario)
        {
            // NO IMPLEMENTADO AÚN
            // Hay que buscar las css's
        }

        $this->tCss = array('default.css', 'admin.css', 'menu.css');
    }

    protected function linkAyuda()
    {
        if (file_exists(sfConfig::get('sf_web_dir') . '/ayudas/' . sfConfig::get('sf_app') . '/index.' . $this->getUser()->getCulture() . '.html'))
        {
            return public_path('ayudas/' . sfConfig::get('sf_app') . '/index.' . $this->getUser()->getCulture() . '.html');
        } else
        {
            return public_path('ayudas/default/index.' . $this->getUser()->getCulture() . '.html');
        }
    }

}

?>
