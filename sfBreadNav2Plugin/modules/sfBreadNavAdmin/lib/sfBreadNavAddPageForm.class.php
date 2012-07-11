<?php

class sfBreadNavAddPageForm extends sfForm
{

    public function configure()
    {
        
    }

    public function setup()
    {


        $this->validatorSchema['id'] = new sfValidatorPass();
        $this->validatorSchema['page'] = new sfValidatorString(array('max_length' => 255));
        $this->validatorSchema['route'] = new sfValidatorString(array('max_length' => 128));
        $this->validatorSchema['credential'] = new sfValidatorString(array('max_length' => 128, 'required' => false));
        $this->validatorSchema['catch_all'] = new sfValidatorPass();
        $this->validatorSchema['parent'] = new sfValidatorPass();
        $this->validatorSchema['order'] = new sfValidatorPass();
        $this->validatorSchema['order_option'] = new sfValidatorPass();
        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setDefault('order_option', 'below');

        parent::setup();
    }

    public function setSelectBoxes($scope)
    {

        $parents = sfBreadNavPeer::getParentArray($scope);
        $order = sfBreadNavPeer::getOrderArray($scope);

        $orderoption = array('above' => 'above', 'below' => 'below');

        $this->widgetSchema['id'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['page'] = new sfWidgetFormInput();
        $this->widgetSchema['route'] = new sfWidgetFormInput();
        $this->widgetSchema['credential'] = new sfWidgetFormInput();
        $this->widgetSchema['catch_all'] = new sfWidgetFormInputCheckbox();
        $this->widgetSchema['parent'] = new sfWidgetFormSelect(array('choices' => $parents));
        $this->widgetSchema['order'] = new sfWidgetFormSelect(array('choices' => $order));
        $this->widgetSchema['order_option'] = new sfWidgetFormSelectRadio(array('choices' => $orderoption));

        $this->widgetSchema->setNameFormat('sfbreadnavaddpageform[%s]');
    }

}