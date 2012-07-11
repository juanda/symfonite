<?php

class DireccionIdUsuarioHiddenForm extends SftDireccionForm {

    public function configure() {
        
        $c = new Criteria();
        $c->addJoin(GenPaisI18nPeer::ID, GenPaisPeer::ID);
        $c->addAscendingOrderByColumn(GenPaisI18nPeer::NOMBRE);
        
        $this->widgetSchema['id_usuario'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['pais'] = new sfWidgetFormPropelChoice(array('model' => 'GenPais', 'add_empty' => true, 'criteria' => $c));

        $this->validatorSchema['pais'] = new sfValidatorPropelChoice(array('model' => 'GenPais', 'column' => 'id', 'required' => false));
    }

}