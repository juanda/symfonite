<?php

/**
 * SftEmail form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftEmailForm extends BaseSftEmailForm
{

    public function configure()
    {
        $this->widgetSchema['id_persona'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['id_organismo'] = new sfWidgetFormInputHidden();

        $this->widgetSchema['predeterminado'] = new sfWidgetFormChoice(array(
                    'expanded' => true,
                    'multiple' => false,
                    'choices' => array('1' => 'primario', '0' => 'secundario')));


        $this->validatorSchema['direccion'] = new sfValidatorString(array('max_length' => 255, 'required' => false));
        $this->validatorSchema['predeterminado'] = new sfValidatorChoice(array('choices' => array('0', '1'), 'required' => false));

        unset($this->widgetSchema['created_at']);
        unset($this->widgetSchema['updated_at']);
        unset($this->validatorSchema['created_at']);
        unset($this->validatorSchema['updated_at']);

        $this->setDefault('id_persona', $this->getOption('id_persona'));
        $this->setDefault('id_organismo', $this->getOption('id_organismo'));
    }

}
