<?php

require_once(sfConfig::get('sf_plugins_dir') . '/edaGuardPlugin/modules/edaGestorSesion/lib/BaseedaGestorSesionActions.class.php');

class edaPAPISesionActions extends BaseedaGestorSesionActions
{

    public function executeIndex(sfWebRequest $request)
    {
        $poa = new PoA("symfonite");

        // comprobamos que estamos autentificados, si no es así se produce una
        // redirección al IdP para solicitar el login y password al hippy.
        $this -> auth = $poa->authenticate();
        $this -> papi_attributes = array();

        if ($this -> auth)
        {
            // recuperamos los atributos devueltos por el IdP
            $papi_attributes = $poa->getAttributes();
//        echo '<pre>';
//        print_r($papi_attributes);
//        echo '</pre>';
//        exit;   
            
            $this->papi_attributes = $papi_attributes;
            if (!is_array($this->papi_attributes))
                $this ->  papi_attributes = array();
            

            $this->setLayout(sfConfig::get('eda_papi_plugin_as_layout','layout'));
            $this->setTemplate('loginExterno');            
        }
        else
        {
            echo 'Mal rollo';
            exit;
        }
        
    }

}
?>
