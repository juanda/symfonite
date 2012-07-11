<?php

class sfBreadNavEditHomeForm extends sfForm
{

    public function configure()
    {
        $this->disableLocalCSRFProtection();
    }

    public function setup()
    {

        $this->setWidgetSchema(new sfWidgetFormSchema(array(
                    'page' => new sfWidgetFormInput(),
                    'route' => new sfWidgetFormInput(),
                    'credential' => new sfWidgetFormInput(),
                    'catch_all' => new sfWidgetFormInputCheckbox()
                )));

        $this->setValidatorSchema(new sfValidatorSchema(array(
                    'page' => new sfValidatorString(array('max_length' => 255)),
                    'route' => new sfValidatorString(array('max_length' => 128)),
                    'credential' => new sfValidatorString(array('max_length' => 128, 'required' => false)),
                    'catch_all' => new sfValidatorPass()
                )));

        $this->widgetSchema->setNameFormat('sfbreadnavedithomeform[%s]');
        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

}