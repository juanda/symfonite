<?php

class sftPAPIAdminActions extends sfActions
{

    public function preExecute()
    {
        parent::preExecute();
        define('PAPI_DBA', null);
        define('GPOA_T', null);
        include(dirname(__FILE__) . '/../../../lib/vendor/phpPoA-2.3/PAPI.conf');
        $this->papi_cfg = $papi_cfg;
    }

    public function executePoaParams(sfWebRequest $request)
    {
        $this->form = new sftPAPI_PoA_AdminForm();

        $pubkey = file_get_contents($this->papi_cfg['PubKeyFile']);

        $this->form->setDefault('redirecturl', $this->papi_cfg['RedirectURL']);
        $this->form->setDefault('pubkey', $pubkey);

        if ($request->isMethod('post'))
        {
            $data = $request->getParameter('papipoa');

            $this->form->bind($data);

            if ($this->form->isValid())
            {
                $this->grabaParametrosPoA($this->form->getValues());
            }
        }
    }    

    protected function grabaParametrosPoA($params)
    {
        $filePAPIconf = dirname(__FILE__) . '/../../../lib/vendor/phpPoA-2.3/PAPI.conf';
        sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
        if (!is_writable($filePAPIconf))
        {
            $file = realpath($filePAPIconf);
            $this->getUser()->setFlash('error1', __('El fichero "' . $file . '" debe tener permisos de escritura para el servidor web'));
        }

        if (!is_writable($this->papi_cfg['PubKeyFile']))
        {
            $file = realpath($this->papi_cfg['PubKeyFile']);
            $this->getUser()->setFlash('error2', __('El fichero "' . $file . '" debe tener permisos de escritura para el servidor web'));
        }

        $fp = fopen($this->papi_cfg['PubKeyFile'], "w");
        fwrite($fp, $params['pubkey']);
        fclose($fp);

        $fs = new sfFilesystem();
        $originFile = dirname(__FILE__) . '/../config_tpl/PAPI.conf';
        $targetFile = $filePAPIconf;
        $fs->copy($originFile, $targetFile, array('override' => true));

        $files = array($targetFile);
        $tokens = array('REDIRECTURL' => $params['redirecturl']);
        $fs->replaceTokens($files, '%%', '%%', $tokens);

        $this->getUser()->setFlash('mensaje', __('Cambios realizado correctamente'));
    }        
}

?>
