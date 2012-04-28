<?php

/**
 * SftAplicacion form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftAplicacionForm extends BaseSftAplicacionForm
{

    public function configure()
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
        
        $this->widgetSchema['id_credencial'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['descripcion'] = new sfWidgetFormTextArea();
        $this->widgetSchema['logotipo'] = new sfWidgetFormInputFile();
        $this->widgetSchema['tipo_login'] = new sfWidgetFormChoice(
                        array(
                            'choices' => array(
                                'normal' => __('Normal (sin SSO)'),
                                'saml' => 'SSO con sistema de identidad federada SAML',
                                'papi' => 'SSO con sistema de identidad federada PAPI',
                            )
                ));

        $this->validatorSchema['codigo'] = new sfValidatorAnd(array(
                    new sfValidatorString(array('max_length' => 250)),
                    new sfValidatorRegex(array('pattern' => '/^[a-zA-Z0-9_]{3,255}$/'), array('invalid' => 'Solo se permiten caracteres alfanuméricos ASCII'))
                ));
        $this->validatorSchema['logotipo'] = new sfValidatorFile(
                        array('max_size' => '100000', 'mime_types' => 'web_images', 'required' => false),
                        array('max_size' => 'Ha superado el tamaño de la imagen permitida (%max_size%)', 'mime_types' => 'tipo de fichero no permitido'));

//        $this->validatorSchema['url'] = new sfValidatorUrl();
    }

}
