<?php

/**
 * sfBreadNavApplication form base class.
 *
 * @method sfBreadNavApplication getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BasesfBreadNavApplicationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'user_id'     => new sfWidgetFormInputText(),
      'name'        => new sfWidgetFormInputText(),
      'application' => new sfWidgetFormInputText(),
      'css'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 255)),
      'application' => new sfValidatorString(array('max_length' => 255)),
      'css'         => new sfValidatorString(array('max_length' => 2000)),
    ));

    $this->widgetSchema->setNameFormat('sf_bread_nav_application[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfBreadNavApplication';
  }


}
