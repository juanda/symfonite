<?php

class themesApplicationConfiguration extends sfApplicationConfiguration
{

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