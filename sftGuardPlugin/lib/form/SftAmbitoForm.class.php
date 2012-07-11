<?php

/**
 * SftAmbito form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftAmbitoForm extends BaseSftAmbitoForm
{
    public function configure()
    {
        unset($this->widgetSchema['sft_acceso_ambito_list']);
        unset($this->validatorSchema['sft_acceso_ambito_list']);

        $c = new Criteria();


        if (!is_null($this->getOption('idUo', null)))
        {
            $c->add(SftPeriodoPeer::ID_UO, $this->getOption('idUo'));
        }

        $this->widgetSchema['id_ambitotipo'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['id_periodo'] = new sfWidgetFormPropelChoice(array(
                    'model' => 'SftPeriodo',
                    'criteria' => $c,
                    'add_empty' => false));
        
        $this->widgetSchema['estado'] = new sfWidgetFormChoice(array('choices' => array('ACTIVO'=>'Activo', 'INACTIVO' => 'Inactivo')));
        
        $this->validatorSchema['id_periodo'] = new sfValidatorPropelChoice(array(
                    'required' => false,
                    'model' => 'SftPeriodo',
                    'criteria' => $c,
                    'column' => 'id'));

        $this->validatorSchema['estado'] = new sfValidatorChoice(array('choices' => array('ACTIVO', 'INACTIVO')));
        
        EmbedI18n::aniadeTraducciones($this);
    }
}
