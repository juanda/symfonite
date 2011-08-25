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


class edaPAPIASActions extends sfActions
{

    public function executeSignin($request)
    {
        $connector_name = sfConfig::get('app_eda_papi_plugin_as_connector', null);
        if (is_null($connector_name))
        {
            throw new Exception('No connector has been defined. You must set eda_papi_plugin_as_connector parameter');
        }

        $signinData = $request->getParameter('signin');
        
        // Create signin form. edaPAPIFormSignin by default
        $formClass = (class_exists($connector_name . 'SigninForm')) ? $connector_name . 'SigninForm' : 'edaPAPISigninForm';
        
        $this->form = new $formClass();

        // Take the PAPI GET parameter and put them in the session. It's easier
        // an safer to handle such parameter from the session.
        // $this -> getUser() gets an object wich represents the session in
        // symfony

        if (!$this->getUser()->getAttributeHolder()->getNames('PAPIREQUEST'))
        {
            foreach ($request->getGetParameters() as $k => $v)
            {
                $this->getUser()->setAttribute($k, $v, 'PAPIREQUEST');
            }
        }

        if ($request->isMethod('post'))
        {
            $this->form->bind($signinData);
            if ($this->form->isValid())
            {
                $connector = ConnectorFactory::createInstance($signinData, $connector_name);
                $auth = $connector->isAuthenticated();
                if ($auth)
                {                    
                    $attributes = $connector->getAttributes();
                } else
                {
                    $this->getUser()->setFlash('message',
                            sfConfig::get('app_eda_papi_plugin_as_message_no_auth', 'incorrect login and/or password'));
                    $this->redirect('edaPAPIAS/signin');
                }

                $papias = new PAPIAS($this->getUser());
                $redirectTo = $papias
                                ->setAttributes($attributes)
                                ->applyFilters()
                                ->buildAssertion()
                                ->buildRedirection();

//                echo $redirectTo; exit;
                $this->getResponse()->setHttpHeader('Location', $redirectTo);
                $this->getResponse()->setHeaderOnly();
            }
        }

        $this->setLayout(sfConfig::get('app_eda_papi_plugin_as_layout', null));
        if (file_exists(dirname(__FILE__) . '/../templates/' . $connector_name . 'SigninSuccess.php'))
        {
            $this->setTemplate($connector_name . 'Signin');
        }
        $this->getResponse()->setStatusCode(401);
    }

}
