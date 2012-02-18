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

require_once dirname(__FILE__) . '/../lib/personaGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/personaGeneratorHelper.class.php';

/**
 * personas actions.
 *
 * @package    kuku
 * @subpackage personas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class personaActions extends autoPersonaActions
{

    function executeListAsociaPerfiles(sfWebRequest $request)
    {
        $this->redirect('asociaperfiles/perfilesAsociados?id_usuario=' . $request->getParameter('id'));
    }

    function executeBorraTelefono(sfWebRequest $request)
    {
        $telefono = SftTelefonoPeer::retrieveByPK($request->getParameter('id'));
        $id_persona = $telefono->getSftPersona()->getId();
        $telefono->delete();

        $this->redirect('persona/edit?id=' . $id_persona);
    }

    function executeBorraEmail(sfWebRequest $request)
    {
        $email = SftEmailPeer::retrieveByPK($request->getParameter('id'));
        $id_persona = $email->getSftPersona()->getId();
        $email->delete();

        $this->redirect('persona/edit?id=' . $id_persona);
    }

    function executeBorraDireccion(sfWebRequest $request)
    {
        $direccion = SftDireccionPeer::retrieveByPK($request->getParameter('id'));
        $id_persona = $direccion->getSftPersona()->getId();
        $direccion->delete();

        $this->redirect('persona/edit?id=' . $id_persona);
    }

    function executeListPassword(sfWebRequest $request)
    {
        $sftUsuario = SftUsuarioPeer::retrieveByPk($request->getParameter('id'));

        $this->redirect('sfGuardUser/edit?id=' . $sftUsuario->dameSfGuardUser()->getId());
    }

    public function executeListAtributos(sfWebRequest $request)
    {
        $this->forward404Unless($request->hasParameter('id'));
        
        $atributo_filter = array('id_usuario' => $request->getParameter('id'));
        $this->getUser()->setAttribute('asociaatributos.filters', $atributo_filter, 'admin_module');

        $this->redirect('asociaatributos/index');
    }

    public function executeListEmails(sfWebRequest $request)
    {
        $this->forward404Unless($request->hasParameter('id'));

        $email_filter = array('id_usuario' => $request->getParameter('id'));
        $this->getUser()->setAttribute('email.filters', $email_filter, 'admin_module');

        $this->redirect('email/index');
    }
    
    public function executeListTelefonos(sfWebRequest $request)
    {
        $this->forward404Unless($request->hasParameter('id'));

        $telefono_filter = array('id_usuario' => $request->getParameter('id'));
        $this->getUser()->setAttribute('telefono.filters', $telefono_filter, 'admin_module');

        $this->redirect('telefono/index');
    }
    
    public function executeListDirecciones(sfWebRequest $request)
    {
        $this->forward404Unless($request->hasParameter('id'));

        $direccion_filter = array('id_usuario' => $request->getParameter('id'));
        $this->getUser()->setAttribute('direccion.filters', $direccion_filter, 'admin_module');

        $this->redirect('direccion/index');
    }

}
