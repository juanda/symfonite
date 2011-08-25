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

require_once dirname(__FILE__).'/../lib/credencialesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/credencialesGeneratorHelper.class.php';

/**
 * credenciales actions.
 *
 * @package    GestionEDAE3
 * @subpackage credenciales
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class credencialesActions extends autoCredencialesActions
{
    public function executeDelete(sfWebRequest $request)
    {
        $id_credencial = $request -> getParameter('id');

        $c = new Criteria();
        $c -> add(EdaAplicacionesPeer::ID_CREDENCIAL, $id_credencial);

        $num_aplicaciones = EdaAplicacionesPeer::doCount($c);

        // La credencial que se quiere borrar es una credencial de acceso y
        // no se debe borrar hasta que no se elimine la aplicación
        if($num_aplicaciones > 0)
        {
            $this->getUser()->setFlash('notice', "This is an application credential and can't be deleted");
            $this->redirect('@eda_credenciales');
        }

        parent::executeDelete($request);

    }
}
