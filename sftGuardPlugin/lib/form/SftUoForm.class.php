<?php

/**
 * SftUo form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftUoForm extends BaseSftUoForm
{

    public function configure()
    {
        EmbedI18n::aniadeTraducciones($this);

        $this->widgetSchema['observaciones'] = new sfWidgetFormTextarea(); 
    }
    
    public function save($con=null)
    {
        $object = parent::save($con);
        
        if($this->isNew)
        {            
            $periodo_inicial = new SftPeriodo();
            $periodo_inicial->setFechainicio(date("Y-m-d"));
            $periodo_inicial->setCodigo('periodo inicial');
            $periodo_inicial->setEstado('ACTIVO');
            $periodo_inicial->setIdUo($this->getObject()->getId());
            $periodo_inicial->save();           
        }
        
        return $object;
    }
    

}
