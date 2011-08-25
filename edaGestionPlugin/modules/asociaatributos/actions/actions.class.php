<?php

require_once dirname(__FILE__).'/../lib/asociaatributosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/asociaatributosGeneratorHelper.class.php';

/**
 * asociaatributos actions.
 *
 * @package    LaMadraza
 * @subpackage asociaatributos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class asociaatributosActions extends autoAsociaatributosActions
{

  public function executeIndex(sfWebRequest $request)
  {
    // sorting
    if ($request->getParameter('sort') && $this->isValidSortColumn($request->getParameter('sort')))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    // pager
    if ($request->getParameter('page'))
    {
      $this->setPage($request->getParameter('page'));
    }

    $this->id_usuario = $request -> getParameter('id_usuario');
    $this->pager = $this->getPager();

    $c = new Criteria();
    $c = $this->pager->getCriteria();
    $c->add(EdaUsuAtributosValoresPeer::ID_USUARIO, $this->id_usuario);
 
    $this->pager->SetCriteria($c);
    $this->pager->init();
    
    $this->nombreUsuario = EdaUsuariosPeer::retrieveByIdSfUser($this->id_usuario);
    
    $this->sort = $this->getSort();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->id_usuario = $request -> getParameter('id_usuario');
    $this->form = $this->configuration->getForm();

    if (isset($this->id_usuario)&&($this->id_usuario != ''))
    {
        $edaUsuario = EdaUsuariosPeer::retrieveByPK($this->id_usuario);
        $this->nombreUsuario = $edaUsuario->NombreCompleto();
        $this->EdaUsuAtributosValores = $this->form->getObject();
        $this->EdaUsuAtributosValores->setIdUsuario($this->id_usuario);
        $this->EdaUsuAtributosValores->setEdaUsuarios($edaUsuario);
        $this->form = $this->configuration->getForm($this->EdaUsuAtributosValores);
   
    }else{
           
           $this->EdaUsuAtributosValores = $this->form->getObject();
           $this->form = $this->configuration->getForm($this->EdaUsuAtributosValores);
         }

  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->EdaUsuAtributosValores = $this->getRoute()->getObject();
    $this->id = $request -> getParameter('id_usuario');

    if (isset($this->id_usuario))
    {
        $this->EdaUsuAtributosValores->setId($this->id_usuario);

        if (EdaUsuariosPeer::retrieveByPk($this->id_usuario))
        {
        $this->nombreUsuario = EdaUsuariosPeer::retrieveByPK($this->id_usuario)->NombreCompleto();
        }

    }

    $this->form = $this->configuration->getForm($this->EdaUsuAtributosValores);

    if (isset($this->id_usuario))
    {
        $this -> form -> getWidget('id_usuario')->setDefault($this->id_usuario);
    }
   
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    $this->id_usuario =$this->getRoute()->getObject()->getIdUsuario();
    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->delete();

    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

    if (isset($this->id_usuario))
    {
        $this->redirect('asociaatributos/index?id_usuario='.$this->id_usuario);
    }else {$this->redirect('@eda_usu_atributos_valores_asociaatributos');}

  }

  public function executeBatch(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    $this->id_usuario = $request->getParameter('usuario');

    if (!$ids = $request->getParameter('ids'))
    {
      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('asociaatributos/index?id_usuario='.$this->id_usuario);

    }

    if (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');

      $this->redirect('asociaatributos/index?id_usuario='.$this->id_usuario);
    }

    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {
      throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
    }

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($action)))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $validator = new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'EdaUsuAtributosValores'));
    try
    {
      // validate ids
      $ids = $validator->clean($ids);

      // execute batch
      $this->$method($request);
    }
    catch (sfValidatorError $e)
    {
      $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items as some items do not exist anymore.');
    }

    $this->redirect('asociaatributos/index?id_usuario='.$this->id_usuario);
  }

  protected function executeBatchDelete(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    $this->id_usuario = $request->getParameter('usuario');
   
    $count = 0;
    foreach (EdaUsuAtributosValoresPeer::retrieveByPks($ids) as $object)
    {
      $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $object)));

      $object->delete();
      if ($object->isDeleted())
      {
        $count++;
      }
    }

    if ($count >= count($ids))
    {
      $this->getUser()->setFlash('notice', 'The selected items have been deleted successfully.');
    }
    else
    {
      $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items.');
    }
   
    if (isset($this->id_usuario))
    {
        $this->redirect('asociaatributos/index?id_usuario='.$this->id_usuario);
    }else {$this->redirect('@eda_usu_atributos_valores_asociaatributos');}
 
  }


}
