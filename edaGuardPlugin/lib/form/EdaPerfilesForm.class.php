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
 * EdaPerfiles form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class EdaPerfilesForm extends BaseEdaPerfilesForm
{
    public function configure()
    {
        unset($this -> widgetSchema['eda_perfil_credencial_list']);
        unset($this -> validatorSchema['eda_perfil_credencial_list']);
        $this -> getWidget('created_at') -> setOption('date', array('format' => '%day% - %month% - %year%'));
        $this -> getWidget('updated_at') -> setOption('date', array('format' => '%day% - %month% - %year%'));

        EmbedI18n::aniadeTraducciones($this);
    }
}
