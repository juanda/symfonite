<?php

/**
 * SftPersona form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftPersonaForm extends BaseSftPersonaForm
{

    public function configure()
    {
        $this->widgetSchema['observaciones'] = new sfWidgetFormTextArea();
        $years = range(1900, date('Y'));
       
        
        $this->widgetSchema['fechanacimiento'] = new sfWidgetFormDate(
                        array('years' => array_combine($years, $years))
        );
        $this->widgetSchema['updated_at'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
        
        $elecciones = array('V' => 'V', 'M' => 'M');
        $this->widgetSchema['sexo'] = new sfWidgetFormChoice(array('choices' => $elecciones));
        $this->validatorSchema['sexo'] = new sfValidatorChoice(array('choices' => $elecciones));
    }

}
