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

require_once dirname(__FILE__) . '/../lib/ambitotipoGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/ambitotipoGeneratorHelper.class.php';

/**
 * ambitostipos actions.
 *
 * @package    GestionEDAE3
 * @subpackage ambitostipos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class ambitoTipoActions extends autoAmbitoTipoActions {

    public function executeListGestionarAmbitos(sfWebRequest $request) {
        $id_ambitotipo = $request->getParameter('id');

        $ambitos_filter = array('id_ambitotipo' => $id_ambitotipo);
        $this->getUser()->setAttribute('ambito.filters', $ambitos_filter, 'admin_module');

        $this->redirect('@sft_ambito');
    }

    public function executeDelete(sfWebRequest $request) {
        $request->checkCSRFProtection();
        $ambito_tipo = SftAmbitoTipoPeer::retrieveByPK($request->getParameter('id'));
        if ($ambito_tipo->countSftAmbitos() != 0) {
            $this->getUser()->setFlash('error', 'No se puede borrar un tipo de ambito con ambitos asociados a él.');
        } else {
            $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
            $this->getRoute()->getObject()->delete();
            $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
        }
        $this->redirect('@sft_ambito_tipo');
    }

}
