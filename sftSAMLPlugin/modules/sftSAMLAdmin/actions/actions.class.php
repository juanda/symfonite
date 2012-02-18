<?php

class sftSAMLAdminActions extends sfActions
{   
    public function executeRunSAMLAdmin(sfWebRequest $request)
    {
        $request = sfContext::getInstance()->getRequest();

        $protocol = ($request->isSecure()) ? 'https://' : 'http://';

        $simplesamlRelUrl = $request->getRelativeUrlRoot() . '/simplesaml/';
        $simplesamlAbsUrl = $protocol . $request->getHost() . $simplesamlRelUrl;

        $this->urladminsaml = $simplesamlAbsUrl.'/index.php';
    }    
}

?>
