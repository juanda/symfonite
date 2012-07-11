<?php

/**
 * SftPerfil form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftPerfilForm extends BaseSftPerfilForm
{

    public function configure()
    {
        unset($this->widgetSchema['sft_perfil_credencial_list']);
        unset($this->validatorSchema['sft_perfil_credencial_list']);
        $this->widgetSchema['updated_at'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
//        $this->getWidget('created_at')->setOption('date', array('format' => '%day% - %month% - %year%'));
//        $this->getWidget('updated_at')->setOption('date', array('format' => '%day% - %month% - %year%'));

        EmbedI18n::aniadeTraducciones($this);
    }

}
