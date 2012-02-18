<?php

/**
 * SftDireccion form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftDireccionForm extends BaseSftDireccionForm
{

    public function configure()
    {
        $this->widgetSchema['id_persona'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['id_organismo'] = new sfWidgetFormInputHidden();

        $this->widgetSchema['id_organismo'] = new sfWidgetFormInputHidden();

        $this->setDefault('id_persona', $this->getOption('id_persona'));
        $this->setDefault('id_organismo', $this->getOption('id_organismo'));
    }

}
