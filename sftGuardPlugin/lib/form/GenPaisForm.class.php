<?php

/**
 * GenPais form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class GenPaisForm extends BaseGenPaisForm
{

    public function configure()
    {
        EmbedI18n::aniadeTraducciones($this);
        
        sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
        $this->widgetSchema['paisoterritorio'] = new sfWidgetFormChoice(
                array(
                    'choices' => array('P' => __('País'), 'T' => __('Territorio')),
                    'expanded'=> true
                    ));
        
        $this->setDefault('paisoterritorio', 'P');
    }

}
