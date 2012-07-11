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

require_once dirname(__FILE__) . '/../lib/perfilGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/perfilGeneratorHelper.class.php';

/**
 * perfiles actions.
 *
 * @package    GestionEDAE3
 * @subpackage perfiles
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class perfilActions extends autoPerfilActions {

    function executeListAsociaCredenciales(sfWebRequest $request) {
        $this->redirect('@sft_credencial_asociacredenciales?asociacred=true&id_perfil=' . $request->getParameter('id'));
    }

    function executeListVerCredenciales(sfWebRequest $request) {
        $this->redirect('@sft_credencial_asociacredenciales?vercred=true&id_perfil=' . $request->getParameter('id'));
    }

    public function executeNew(sfWebRequest $request) {
        parent::executeNew($request);

        $perfiles_filter = $this->getUser()->getAttribute('perfil.filters', null, 'admin_module');

        if (isset($perfiles_filter['id_uo'])) {
            $this->form->setDefault('id_uo', $perfiles_filter['id_uo']);
        }
    }

    public function executeDelete(sfWebRequest $request) {
        $request->checkCSRFProtection();
        $perfil = SftPerfilPeer::retrieveByPK($request->getParameter('id'));
        if (!strcmp($request->getParameter('id'), $this->getUser()->getAttribute('idPerfil', null, 'SftUser'))) {
            $this->getUser()->setFlash('error', 'No se puede borrar el perfil que está siendo actuálmente utilizado para acceder a la aplicación.');
        } else if ($perfil->countSftAccesos() != 0) {
            $this->getUser()->setFlash('error', 'No se puede un perfil mientras haya personas asociadas a él.');
        } else {
            $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

            $this->getRoute()->getObject()->delete();

            $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
        }
        $this->redirect('@sft_perfil');
    }

}
