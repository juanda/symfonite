<?php

class themesPluginConfiguration extends sfPluginConfiguration
{

    public function initialize()
    {
        
        $themeManager = new themeManager();
        // Only bootstrap if theming is enabled
        if (sfConfig::has('app_tema'))
        {
            $this->dispatcher->connect('context.load_factories', array($themeManager, 'addAssets'));
        }
    }

}
