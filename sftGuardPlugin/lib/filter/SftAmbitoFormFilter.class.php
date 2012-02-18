<?php

/**
 * SftAmbito filter form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
class SftAmbitoFormFilter extends BaseSftAmbitoFormFilter
{

    public function configure($options=null)
    {
        $c = new Criteria();


        if (!is_null($this->getOption('idUo', null)))
        {
            $c->add(SftPeriodoPeer::ID_UO, $this->getOption('idUo'));
        }
        unset($this->widgetSchema['sft_acceso_ambito_list']);
        unset($this->validatorSchema['sft_acceso_ambito_list']);

        $this->widgetSchema['id_ambitotipo'] = new sfWidgetFormPropelChoice(array('model' => 'SftAmbitotipo', 'add_empty' => false));

        $this->widgetSchema['id_periodo'] = new sfWidgetFormPropelChoice(array(
                    'model' => 'SftPeriodo',
                    'criteria' => $c,
                    'add_empty' => true));

        $this->validatorSchema['id_periodo'] = new sfValidatorPropelChoice(array(
                    'required' => false,
                    'model' => 'SftPeriodo',
                    'criteria' => $c,
                    'column' => 'id'));
    }

}
