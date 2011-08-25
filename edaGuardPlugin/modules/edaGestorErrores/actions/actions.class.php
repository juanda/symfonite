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

/**
 * gestorErrores actions.
 *
 * @package    repositorioActividades
 * @subpackage gestorErrores
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class edaGestorErroresActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex($request)
    {

    }

    public function executeFicheroPesado($request)
    {
        $this -> mensaje = "El fichero que intentas envíar sobrepasa el límite permitido por el servidor: ". ini_get('upload_max_filesize');
    }


    public function executeDisabled($request)
    {

    }

    public function executeError404($request)
    {
        $this -> setLayout('inicio');
    }

    public function executeMantenimiento($request)
    {
        $this -> setLayout('inicio');
    }

    public function executeIndexSymfony($request)
    {

    }

    public function executeLogin($request)
    {

    }

    public function executeModule($request)
    {

    }

    public function executeSecure($request)
    {
        $this -> setLayout('inicio');
    }

    public function executeMensajeError($request)
    {
        $this -> setLayout('inicio');
        $this -> mensaje = $request -> getParameter('mensaje');
    }
} 