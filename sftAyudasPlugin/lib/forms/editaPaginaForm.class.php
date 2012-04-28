<?php

/*
 * Copyright 2010 Instituto de Tecnologías Educativas - Ministerio de Educación de España
 *
 * Licencia con arreglo a la EUPL, Versión 1.1 exclusivamente
 * (la «Licencia»);
 * Solo podrá usarse esta obra si se respeta la Licencia.
 * Puede obtenerse una copia de la Licencia en:
 *
 * http://ec.europa.eu/idabc/eupl5
 *
 * y también en:

 * http://ec.europa.eu/idabc/en/document/7774.html
 *
 * Salvo cuando lo exija la legislación aplicable o se acuerde
 * por escrito, el programa distribuido con arreglo a la
 * Licencia se distribuye «TAL CUAL»,
 * SIN GARANTÍAS NI CONDICIONES DE NINGÚN TIPO, ni expresas
 * ni implícitas.
 * Véase la Licencia en el idioma concreto que rige
 * los permisos y limitaciones que establece la Licencia.
 */
?>
<?php

/**
 * EdaAccesoAmbito form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class editaPaginaForm extends sfForm
{

    public function configure()
    {        
        $this->setWidgets(array(
            'nombre_pagina' => new sfWidgetFormInputText(),
            'texto'         => new sfWidgetFormTextarea(),
        ));

        $this->setValidators(array(
            'nombre_pagina' => new sfValidatorString(array('required' => false)),
            'texto'         => new sfValidatorString(),
        ));

        $this->widgetSchema->setNameFormat('edita_pagina[%s]');
    }
}

