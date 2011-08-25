<?php

/**
 * sfBreadNav filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BasesfBreadNavFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'page'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'title'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'module'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'action'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'credential'  => new sfWidgetFormFilterInput(),
      'catchall'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'tree_left'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tree_right'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tree_parent' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'scope'       => new sfWidgetFormPropelChoice(array('model' => 'sfBreadNavApplication', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'page'        => new sfValidatorPass(array('required' => false)),
      'title'       => new sfValidatorPass(array('required' => false)),
      'module'      => new sfValidatorPass(array('required' => false)),
      'action'      => new sfValidatorPass(array('required' => false)),
      'credential'  => new sfValidatorPass(array('required' => false)),
      'catchall'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'tree_left'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tree_right'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tree_parent' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'scope'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfBreadNavApplication', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('sf_bread_nav_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfBreadNav';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'page'        => 'Text',
      'title'       => 'Text',
      'module'      => 'Text',
      'action'      => 'Text',
      'credential'  => 'Text',
      'catchall'    => 'Boolean',
      'tree_left'   => 'Number',
      'tree_right'  => 'Number',
      'tree_parent' => 'Number',
      'scope'       => 'ForeignKey',
    );
  }
}
