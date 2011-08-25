<?php

/**
 * sfBreadNav form base class.
 *
 * @method sfBreadNav getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BasesfBreadNavForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'page'        => new sfWidgetFormInputText(),
      'title'       => new sfWidgetFormInputText(),
      'module'      => new sfWidgetFormInputText(),
      'action'      => new sfWidgetFormInputText(),
      'credential'  => new sfWidgetFormInputText(),
      'catchall'    => new sfWidgetFormInputCheckbox(),
      'tree_left'   => new sfWidgetFormInputText(),
      'tree_right'  => new sfWidgetFormInputText(),
      'tree_parent' => new sfWidgetFormInputText(),
      'scope'       => new sfWidgetFormPropelChoice(array('model' => 'sfBreadNavApplication', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'page'        => new sfValidatorString(array('max_length' => 255)),
      'title'       => new sfValidatorString(array('max_length' => 255)),
      'module'      => new sfValidatorString(array('max_length' => 128)),
      'action'      => new sfValidatorString(array('max_length' => 128)),
      'credential'  => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'catchall'    => new sfValidatorBoolean(array('required' => false)),
      'tree_left'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'tree_right'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'tree_parent' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'scope'       => new sfValidatorPropelChoice(array('model' => 'sfBreadNavApplication', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('sf_bread_nav[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfBreadNav';
  }


}
