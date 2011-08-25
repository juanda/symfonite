<?php

class arrayWithFormSigninForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'usuario' => new sfWidgetFormInput(),
      'clave' => new sfWidgetFormInput(array('type' => 'password')),
      'dni'   => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'usuario' => new sfValidatorString(),
      'clave' => new sfValidatorString(),
      'dni'   => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('signin[%s]');
  }
}
