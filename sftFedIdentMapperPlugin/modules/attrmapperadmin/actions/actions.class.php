<?php

require_once dirname(__FILE__).'/../lib/attrmapperadminGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/attrmapperadminGeneratorHelper.class.php';

/**
 * attrmapperadmin actions.
 *
 * @package    basico
 * @subpackage attrmapperadmin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class attrmapperadminActions extends autoAttrmapperadminActions
{
    
    function executeListAsociaPerfiles(sfWebRequest $request)
    {
        $this->redirect('fid_asociaperfiles/index?id_atributo=' . $request->getParameter('id'));
    }
    
    function executeListAsociaAmbitos(sfWebRequest $request)
    {
        $this->redirect('fid_asociaambitos/index?id_atributo=' . $request->getParameter('id'));
    }
        
}
