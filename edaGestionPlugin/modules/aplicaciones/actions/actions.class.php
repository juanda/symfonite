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

require_once dirname(__FILE__).'/../lib/aplicacionesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/aplicacionesGeneratorHelper.class.php';

/**
 * aplicaciones actions.
 *
 * @package    GestionEDAE3
 * @subpackage aplicaciones
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class aplicacionesActions extends autoAplicacionesActions
{
    public function executeGeneraClave(sfWebRequest $request)
    {
        $longitud = 15;
        $password = Utilidades::generaClave($longitud);

        $this -> clave = substr(md5($password), 0 , $longitud);
    }

    public function executeDelete(sfWebRequest $request)
    {
        $aplicacion = EdaAplicacionesPeer::retrieveByPK($request -> getParameter('id'));
        $aplicacion -> setIdCredencial(null);
        $aplicacion -> save();

        $c = new Criteria();
        $c -> add(EdaCredencialesPeer::ID_APLICACION, $request -> getParameter('id'));

        EdaCredencialesPeer::doDelete($c);

        parent::executeDelete($request);
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

            $crearCredencialDeAcceso =  $form->getObject()->isNew();

            $file = $form -> getValue('logotipo');
            if($file instanceof sfValidatedFile)
            {

                $nombreFichero =  sha1($file -> getOriginalName().rand(11111, 99999)).$file -> getExtension($file -> getOriginalExtension());
                $file -> save(sfConfig::get('sf_upload_dir').'/'.$nombreFichero);

            }   

            $EdaAplicaciones = $form->save();
            
            if($file instanceof  sfValidatedFile)
            {
                $form -> getObject() -> setLogotipo(basename($file -> getSavedName()));
                $form -> getObject() -> save();
            }

            if($crearCredencialDeAcceso)
            {
                $credencial = new EdaCredenciales();
                $credencial -> setIdAplicacion($EdaAplicaciones -> getId());
                $credencial -> setNombre($EdaAplicaciones -> getCodigo().'_ACCESO');
                $credencial -> setDescripcion('Credencial de acceso de la aplicación:'.$EdaAplicaciones -> getCodigo());

                $credencial -> save();

                $EdaAplicaciones -> setIdCredencial($credencial -> getId());
                $EdaAplicaciones -> save();
            }
            else
            {
                $credencial = $EdaAplicaciones -> getEdaCredenciales();
                $credencial -> setNombre($EdaAplicaciones -> getCodigo().'_ACCESO');
                $credencial -> setDescripcion('Credencial de acceso de la aplicación:'.$EdaAplicaciones -> getCodigo());

                $credencial -> save();
            }

            $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $EdaAplicaciones)));

            if ($request->hasParameter('_save_and_add'))
            {
                $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

                $this->redirect('@eda_aplicaciones_new');
            }
            else
            {
                $this->getUser()->setFlash('notice', $notice);

                $this->redirect(array('sf_route' => 'eda_aplicaciones_edit', 'sf_subject' => $EdaAplicaciones));
            }
        }
        else
        {
            $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
        }
    }

}
