<?php
class SftUsuariosConActivoAliasCulturaForm extends SftUsuarioForm
{
    public function configure()
    {
        parent::configure();
        
        $this->widgetSchema['id'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['id_sfuser'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['fecha_alta'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['fecha_baja'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['updated_at'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['id_persona'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['id_organismo'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['idp'] = new sfWidgetFormInputHidden();
    }
}
?>
