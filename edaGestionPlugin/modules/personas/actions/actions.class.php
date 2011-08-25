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

require_once dirname(__FILE__).'/../lib/personasGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/personasGeneratorHelper.class.php';

/**
 * personas actions.
 *
 * @package    kuku
 * @subpackage personas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class personasActions extends autoPersonasActions
{
    function executeListAsociaPerfiles(sfWebRequest $request)
    {
        $this -> redirect('asociaperfiles/perfilesAsociados?id_usuario='.$request -> getParameter('id'));
    }

    function executeBorraTelefono(sfWebRequest $request)
    {
        $telefono = EdaTelefonosPeer::retrieveByPK($request -> getParameter('id'));
        $id_persona = $telefono -> getEdaPersonas() -> getId();
        $telefono -> delete();

        $this -> redirect('personas/edit?id='.$id_persona);   
    }

    function executeBorraEmail(sfWebRequest $request)
    {
        $email = EdaEmailsPeer::retrieveByPK($request -> getParameter('id'));
        $id_persona = $email -> getEdaPersonas() -> getId();
        $email -> delete();

        $this -> redirect('personas/edit?id='.$id_persona);
    }

    function executeBorraDireccion(sfWebRequest $request)
    {
        $direccion = EdaDireccionesPeer::retrieveByPK($request -> getParameter('id'));
        $id_persona = $direccion -> getEdaPersonas() -> getId();
        $direccion -> delete();

        $this -> redirect('personas/edit?id='.$id_persona);
    }

    function executeListPassword(sfWebRequest $request)
    {
        $edaUsuario = EdaUsuariosPeer::retrieveByPk($request -> getParameter('id'));
      
        $this -> redirect('sfGuardUser/edit?id='.$edaUsuario -> dameSfGuardUser() -> getId());
    }

    public function executeListAtributos(sfWebRequest $request)
    {
        $this -> forward404Unless($request -> hasParameter('id'));

        $edaUsuario = EdaUsuariosPeer::retrieveByPk($request -> getParameter('id'));
        $this -> redirect('asociaatributos/index?id_usuario='.$edaUsuario->getId());

        //$this -> redirect('asociaatributos/index?id_usuario='.$edaUsuario -> dameSfGuardUser() -> getId());
        //$this -> redirect('asociaatributos/index?id='.$edaUsuario->getId());
    }

}
