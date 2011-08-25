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

require_once dirname(__FILE__).'/../lib/organismosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/organismosGeneratorHelper.class.php';

/**
 * organismos actions.
 *
 * @package    GestionEDAE3
 * @subpackage organismos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class organismosActions extends autoOrganismosActions
{
    function executeListAsociaPerfiles(sfWebRequest $request)
    {
        $this -> redirect('asociaperfiles/perfilesAsociados?id_usuario='.$request -> getParameter('id'));
    }

    function executeBorraTelefono(sfWebRequest $request)
    {
        $telefono = EdaTelefonosPeer::retrieveByPK($request -> getParameter('id'));
        $id_organismo = $telefono -> getEdaOrganismos() -> getId();
        $telefono -> delete();

        $this -> redirect('organismos/edit?id='.$id_organismo);
    }

    function executeBorraEmail(sfWebRequest $request)
    {
        $email = EdaEmailsPeer::retrieveByPK($request -> getParameter('id'));
        $id_organismo = $email -> getEdaOrganismos() -> getId();
        $email -> delete();

        $this -> redirect('organismos/edit?id='.$id_organismo);
    }

    function executeBorraDireccion(sfWebRequest $request)
    {
        $direccion = EdaDireccionesPeer::retrieveByPK($request -> getParameter('id'));
        $id_organismo = $direccion -> getEdaOrganismos() -> getId();
        $direccion -> delete();

        $this -> redirect('organismos/edit?id='.$id_organismo);
    }

    function executeListPassword(sfWebRequest $request)
    {
        $edaUsuario = EdaUsuariosPeer::retrieveByPk($request -> getParameter('id'));

        $this -> redirect('sfGuardUser/edit?id='.$edaUsuario -> dameSfGuardUser() -> getId());
    }
}
