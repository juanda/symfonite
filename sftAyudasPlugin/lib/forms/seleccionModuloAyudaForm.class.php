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
class seleccionModuloAyudaForm extends sfForm
{

    public function configure()
    {
        $this->buscaModulos();
        $this->setWidgets(array(            
            'modulos' => new sfWidgetFormChoice(array('choices' => $this->tModulos)),
            'idiomas' => new sfWidgetFormPropelChoice(array('model' => 'EdaCulturas', 'key_method' => 'getNombre')),
            'paginas' => new sfWidgetFormChoice(array('choices' => array())),
        ));

        $this->setValidators(array(            
            'modulos' => new sfValidatorString(array('max_length' => 100)),
            'idiomas' => new sfValidatorPropelChoice(array('model'=>'EdaCulturas', 'column' => 'nombre')),
            'paginas' => new sfValidatorString(array('max_length' => 100)),
        ));

         $this->widgetSchema->setNameFormat('modulo_ayuda[%s]');
    }

    protected function buscaModulos()
    {
        // Obtenemos los módulos del Proyecto
        $aRuta = sfConfig::get('sf_app_module_dir');
        $aRutaModulosPlugins = sfConfig::get('sf_plugins_dir');
        $this->tModulos = array();        

        if (is_dir($aRuta) && is_dir($aRutaModulosPlugins))
        {
            if ($dh = opendir($aRuta))
            {
                while (($file = readdir($dh)) !== false)
                {
                    if (is_dir($aRuta . '/' . $file) && $file != "." && $file != ".." && $file != ".svn")
                    {
                        $this->tModulos [$file] = $file;
                    }
                }
                closedir($dh);
            }

            if($dhp = opendir($aRutaModulosPlugins))
            {
                while (($file = readdir($dhp)) !== false)
                {
                    if (is_dir($aRutaModulosPlugins . '/' . $file.'/modules') && $file != "." && $file != ".." && $file != ".svn")
                    {
                        $this->tModulos [$file] = $file;
                    }
                }
                closedir($dhp);
            }
            
        } else
        {
            sfContext::getInstance()->getController()->redirect('sftGestorErrores/mensajeError?mensaje=No se pueden listar los módulos del proyecto.');
        }
    }
}
