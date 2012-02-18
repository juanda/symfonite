<?php

require_once(sfConfig::get('sf_plugins_dir') . '/sftGuardPlugin/modules/sftGestorSesion/lib/BasesftGestorSesionActions.class.php');

class sftSAMLSesionActions extends BasesftGestorSesionActions
{

    public function executeIndex(sfWebRequest $request)
    {
        // Recuperamos el nombre de la cookie de sesión de la aplicación que
        // está pidiendo el SSO
        $sf_factories = sfYaml::load(sfConfig::get('sf_app_dir') . '/config/factories.yml');
        $app_session_name = $sf_factories['all']['storage']['param']['session_name'];

        // simpleSAMLphp utiliza como nombre de cookie de sesión PHPSESSID,
        // cerramos la sesión y volvemos a abrirla con el nombre que precisa
        // simpleSAMLphp para sus correcto funcionamiento
        session_write_close();
        session_name('PHPSESSID');
        if ($request->getCookie('PHPSESSID') != NULL)
        {
            session_id($request->getCookie('PHPSESSID'));
        }

        session_start();

        $as = new SimpleSAML_Auth_Simple('default-sp');

        // comprobamos que estamos autentificados, si no es así se produce una
        // redirección al IdP para solicitar el login y password al hippy.
        $as->requireAuth();

        // recuperamos los atributos devueltos por el IdP
        $saml_attributes = $as->getAttributes();
//        echo '<pre>';
//        print_r($saml_attributes);
//        echo '</pre>';
//        exit;
        //session_write_close();
        // Restauramos el nombre original de la cookie sesión. Es importante
        // utilizar este nombre para que, en un mismo navegador, podamos tener
        // abiertas varias aplicaciones symfonite en un mismo dominio sin que
        // se produzcan interferncias indeseadas entre sus sesiones.
        session_name($app_session_name);

        // Si el IdP que responde es el interno. y además devuelve un atributo
        // denominado 'id_sfuser', entonces se
        // trata del IdP que utiliza la misma base de datos que las aplicaciones
        // symfonite. En tal caso recuperamos el valor de este parámetro y lo
        // utilizamos para iniciar una sesión symfonite.        
        if (($as->getAuthData('saml:sp:IdP') == sfConfig::get('app_idp_interno')) &&
                isset($saml_attributes['id_sfuser'][0]) &&
                is_numeric($saml_attributes['id_sfuser'][0]))
        {
            $this->getUser()
                    ->setAttribute('id_usuario_from_saml', $saml_attributes['id_sfuser'][0], 'SftUser');
            parent::executeIndex($request);
        }
        // Si se trata de un IdP "externo", entonces hay que crear al usuario en
        // el sistema, si no está aún creado, y realizar un mapeo de los atributos
        else
        {
            $this->saml_attributes = array();
            $this->saml_attributes = $saml_attributes;
            $this->setLayout('inicio');
            $this->setTemplate('loginExterno');
           
        }
    }

    public function executeLogout(sfWebRequest $request)
    {
        // Recuperamos el nombre de la cookie de sesión de la aplicación que
        // está pidiendo el SSO
        $sf_factories = sfYaml::load(sfConfig::get('sf_app_dir') . '/config/factories.yml');
        $app_session_name = $sf_factories['all']['storage']['param']['session_name'];

        // simpleSAMLphp utiliza como nombre de cookie de sesión PHPSESSID,
        // cerramos la sesión y volvemos a abrirla con el nombre que precisa
        // simpleSAMLphp para sus correcto funcionamiento
        session_write_close();
        session_name('PHPSESSID');
        if ($request->getCookie('PHPSESSID') != NULL)
        {
            session_id($request->getCookie('PHPSESSID'));
        }

        session_start();

        $as = new SimpleSAML_Auth_Simple('default-sp');

        // Una vez hecho el logout en el IdP, lo hacemos en el SP. Por eso
        // redirigimos a la acción de logout del SP
        sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
        $as->logout(url_for('sftGestorSesion/signout'));
    }

}

?>
