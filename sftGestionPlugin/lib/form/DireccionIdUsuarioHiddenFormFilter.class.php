<?php

class DireccionIdUsuarioHiddenFormFilter extends SftDireccionFormFilter {

    public function configure() {
        $this->widgetSchema['id_usuario'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['id_persona'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['id_organismo'] = new sfWidgetFormInputHidden();

        $this->setDefault('id_persona', $this->getOption('id_persona'));
        $this->setDefault('id_organismo', $this->getOption('id_organismo'));
    }

}
