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

require_once dirname(__FILE__) . '/../lib/aplicacionGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/aplicacionGeneratorHelper.class.php';

/**
 * aplicacion actions.
 *
 * @package    GestionEDAE3
 * @subpackage aplicacion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class aplicacionActions extends autoAplicacionActions
{

    public function executeGeneraClave(sfWebRequest $request)
    {
        $longitud = 15;
        $password = Utilidades::generaClave($longitud);

        $this->clave = substr(md5($password), 0, $longitud);
    }

    public function executeCreate(sfWebRequest $request)
    {
        $this->form = $this->configuration->getForm();
        $this->SftAplicacion = $this->form->getObject();

        $data = $request->getParameter($this->form->getName());
        sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
        $this->getUser()->setFlash('notice2', __('Si la aplicación que acabas de registrar va a ser desarrollada con symofny, para crear los ficheros de la aplicación debes ejecutar desde una CLI y con los permisos adecuados el siguiente comando:
            php ' . sfConfig::get('sf_root_dir') . '/symfony generate:appITE ' . $data['codigo'] . ' --clave=' . $data['clave'] . ' --titulo=\'' . $data['nombre'] . '\''));

        $this->processForm($request, $this->form);

        $this->setTemplate('new');
    }

    public function executeDelete(sfWebRequest $request)
    {
        $aplicacion = SftAplicacionPeer::retrieveByPK($request->getParameter('id'));
        //borramos el menu asociado
        $c = new Criteria();
        $c->add(sfBreadNavApplicationPeer::APPLICATION, $aplicacion->getCodigo());

        $menu = sfBreadNavApplicationPeer::doSelectOne($c);
        if ($menu instanceof sfBreadNavApplication)
        {
            $scope = $menu->getId();
            $c = new Criteria();
            $c->add(sfBreadNavPeer::SCOPE, $scope);
            $menu_items = sfBreadNavPeer::doDelete($c);

            $menu->delete();
        }

        parent::executeDelete($request);
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

            $crearCredencialDeAcceso = $form->getObject()->isNew();

            $file = $form->getValue('logotipo');
            if ($file instanceof sfValidatedFile)
            {

                $nombreFichero = sha1($file->getOriginalName() . rand(11111, 99999)) . $file->getExtension($file->getOriginalExtension());
                $file->save(sfConfig::get('sf_upload_dir') . '/' . $nombreFichero);
            }

            $SftAplicacion = $form->save();

            if ($file instanceof sfValidatedFile)
            {
                $form->getObject()->setLogotipo(basename($file->getSavedName()));
                $form->getObject()->save();
            }

            if ($crearCredencialDeAcceso)
            {
                $credencial = new SftCredencial();
                $credencial->setIdAplicacion($SftAplicacion->getId());
                $credencial->setNombre($SftAplicacion->getCodigo() . '_ACCESO');
                $credencial->setDescripcion('Credencial de acceso de la aplicación:' . $SftAplicacion->getCodigo());

                $credencial->save();

                $SftAplicacion->setIdCredencial($credencial->getId());
                $SftAplicacion->save();
            } else
            {
                $credencial = $SftAplicacion->getSftCredencial();
                $credencial->setNombre($SftAplicacion->getCodigo() . '_ACCESO');
                $credencial->setDescripcion('Credencial de acceso de la aplicación:' . $SftAplicacion->getCodigo());

                $credencial->save();
            }

            $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $SftAplicacion)));

            if ($request->hasParameter('_save_and_add'))
            {
                $this->getUser()->setFlash('notice', $notice . ' You can add another one below.');

                $this->redirect('@sft_aplicacion_new');
            } else
            {
                $this->getUser()->setFlash('notice', $notice);

                $this->redirect(array('sf_route' => 'sft_aplicacion_edit', 'sf_subject' => $SftAplicacion));
            }
        } else
        {
            $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
        }
    }

    public function executeListEditaMenu(sfWebRequest $request)
    {
        $this->forward404Unless($request->hasParameter('id'));

        $app = SftAplicacionPeer::retrieveByPK($request->getParameter('id'));

        $c = new Criteria();
        $c->add(sfBreadNavApplicationPeer::APPLICATION, $app->getCodigo());

        $menu = sfBreadNavApplicationPeer::doSelectOne($c);

        if (!$menu instanceof sfBreadNavApplication)
        {
            $menu = new sfBreadNavApplication();
            $menu->setApplication($app->getCodigo());
            $menu->setName('menu_' . $app->getCodigo());
            $menu->save();
        }
        $id_menu = $menu->getId();

        $this->redirect('sfBreadNavAdmin/index?scope=' . $id_menu);
    }

    public function executeListCredenciales(sfWebRequest $request)
    {
        $this->forward404Unless($request->hasParameter('id'));

        $app = SftAplicacionPeer::retrieveByPK($request->getParameter('id'));

        $credencial_filter = array('id_aplicacion' => $app->getId());
        $this->getUser()->setAttribute('credencial.filters', $credencial_filter, 'admin_module');

        $this->redirect('credencial/index');
    }

    protected function executeBatchLoginSAML(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');

        $count = 0;
        foreach (SftAplicacionPeer::retrieveByPks($ids) as $object)
        {
            $this->dispatcher->notify(new sfEvent($this, 'admin.kuku_object', array('object' => $object)));

            $object->setTipoLogin('saml');
            $object->save();            
        }

//        if ($count >= count($ids))
//        {
//            $this->getUser()->setFlash('notice', 'The selected items have been changed successfully.');
//        } else
//        {
//            $this->getUser()->setFlash('error', 'A problem occurs when changing the selected items.');
//        }

        $this->redirect('@sft_aplicacion');
    }
    
    protected function executeBatchLoginPAPI(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');

        $count = 0;
        foreach (SftAplicacionPeer::retrieveByPks($ids) as $object)
        {
            $this->dispatcher->notify(new sfEvent($this, 'admin.kuku_object', array('object' => $object)));

            $object->setTipoLogin('papi');
            $object->save();            
        }

//        if ($count >= count($ids))
//        {
//            $this->getUser()->setFlash('notice', 'The selected items have been changed successfully.');
//        } else
//        {
//            $this->getUser()->setFlash('error', 'A problem occurs when changing the selected items.');
//        }

        $this->redirect('@sft_aplicacion');
    }
    
    protected function executeBatchLoginNormal(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');

        $count = 0;
        foreach (SftAplicacionPeer::retrieveByPks($ids) as $object)
        {
            $this->dispatcher->notify(new sfEvent($this, 'admin.kuku_object', array('object' => $object)));

            $object->setTipoLogin('normal');
            $object->save();            
        }

//        if ($count >= count($ids))
//        {
//            $this->getUser()->setFlash('notice', 'The selected items have been changed successfully.');
//        } else
//        {
//            $this->getUser()->setFlash('error', 'A problem occurs when changing the selected items.');
//        }

        $this->redirect('@sft_aplicacion');
    }

}
