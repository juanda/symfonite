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

class ##APP_NAME##Configuration extends sfApplicationConfiguration
{
  public function configure()
  {
  }

  public function getTemplateDirs($moduleName)
    {

        $plugins = $this->getPlugins();

        if (in_array('themesPlugin', $plugins))
        {
            $dirs = array();

            $dirs[] = sfConfig::get('sf_app_module_dir') . '/' . $moduleName . '/templates';                  // application
            if (sfConfig::has('app_tema'))
            {
                array_push($dirs, sfConfig::get('sf_plugins_dir') . '/themesPlugin/templates/themes/' . sfConfig::get('app_tema') . '/modules/' . $moduleName);
            }

            $dirs = array_merge($dirs, $this->getPluginSubPaths('/modules/' . $moduleName . '/templates')); // plugins
            array_push($dirs, sfConfig::get('sf_plugins_dir') . '/themesPlugin/templates/themes/default/modules/' . $moduleName);
            $dirs[] = $this->getSymfonyLibDir() . '/controller/' . $moduleName . '/templates';                // core modules
            $dirs[] = sfConfig::get('sf_module_cache_dir') . '/auto' . ucfirst($moduleName . '/templates');   // generated templates in cache
            return $dirs;
        } else
        {
            parent::getTemplateDirs($moduleName);
        }
    }

    public function getDecoratorDirs()
    {

        $dirs = parent::getDecoratorDirs();

        $plugins = $this->getPlugins();

        if (in_array('themesPlugin', $plugins))
        {
            if (sfConfig::has('app_tema'))
            {
                array_push($dirs, sfConfig::get('sf_plugins_dir') . '/themesPlugin/templates/themes/' . sfConfig::get('app_tema') . '/layouts');
            }
            array_push($dirs, sfConfig::get('sf_plugins_dir') . '/themesPlugin/templates/themes/default/layouts');
        }

        return $dirs;
    }
}
