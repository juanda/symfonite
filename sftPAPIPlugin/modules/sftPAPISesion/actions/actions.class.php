<?php

require_once(sfConfig::get('sf_plugins_dir') . '/sftGuardPlugin/modules/sftGestorSesion/lib/BasesftGestorSesionActions.class.php');

class sftPAPISesionActions extends BasesftGestorSesionActions
{

    public function executeIndex(sfWebRequest $request)
    {
        $poa = new PoA("symfonite");

        // comprobamos que estamos autentificados, si no es así se produce una
        // redirección al IdP para solicitar el login y password al hippy.
        $this->auth = $poa->authenticate();
        $this->papi_attributes = array();

        if ($this->auth)
        {
            // recuperamos los atributos devueltos por el IdP
            $papi_attributes = $poa->getAttributes();
//        echo '<pre>';
//        print_r($papi_attributes);
//        echo '</pre>';
//        exit;  
            if (($poa->getAttribute(PROTO_ATTR_AS_ID, NS_PAPI_PROTOCOL) == sfConfig::get('app_sft_papi_plugin_as_id')) &&
                    isset($papi_attributes['id_sfuser']) &&
                    is_numeric($papi_attributes['id_sfuser']))
            {
                $this->getUser()
                        ->setAttribute('id_usuario_from_papi', $papi_attributes['id_sfuser'], 'SftUser');
                parent::executeIndex($request);
            }
            // Si se trata de un IdP "externo", entonces hay que crear al usuario en
            // el sistema, si no está aún creado, y realizar un mapeo de los atributos
            else
            {
                $this->papi_attributes = $papi_attributes;
                if (!is_array($this->papi_attributes))
                    $this->papi_attributes = array();


                $this->setLayout(sfConfig::get('sft_papi_plugin_as_layout', 'layout'));
                $this->setTemplate('loginExterno');
            }
        }
        else
        {
            echo 'Mal rollo';
            exit;
        }
    }

}

?>
