<?php

class themeManager
{

    protected $_context;

    public function addAssets(sfEvent $event)
    {
        $this->_context = $event->getSubject();

        $assets = sfConfig::get('app_assets');

//        echo '<pre>';
//        print_r($assets);
//        echo '</pre>';
//        exit;
//        // CSS
        if (isset($assets['stylesheets']) && is_array($assets['stylesheets']))
        {
            foreach ($assets['stylesheets'] as $key => $css)
            {
//            echo sfConfig::get('sf_web_dir') . '/themesPlugin/themes/' . sfConfig::get('app_tema') . '/' . $css;
//            echo '<br/>';
                if (file_exists(sfConfig::get('sf_web_dir') . '/themesPlugin/themes/' . sfConfig::get('app_tema') . '/' . $css))
                {
                    $assets['stylesheets'][$key] = '../themesPlugin/themes/' . sfConfig::get('app_tema') . '/' . $css;
                } else
                {
                    $assets['stylesheets'][$key] = '../themesPlugin/themes/default/' . $css;
                }
            }
            $this->_addStylesheets($assets['stylesheets']);
        }

        if (isset($assets['javascripts']) && is_array($assets['javascripts']))
        {
            foreach ($assets['javascripts'] as $key => $js)
            {
//            echo sfConfig::get('sf_web_dir') . '/themesPlugin/themes/' . sfConfig::get('app_tema') . '/' . $js;
//            exit;
                if (file_exists(sfConfig::get('sf_web_dir') . '/themesPlugin/themes/' . sfConfig::get('app_tema') . '/' . $js))
                {
                    $assets['javascripts'][$key] = '../themesPlugin/themes/' . sfConfig::get('app_tema') . '/' . $js;
                } else
                {
                    $assets['javascripts'][$key] = '../themesPlugin/themes/default/' . $js;
                }
            }
            $this->_addJavascripts($assets['javascripts']);
        }
        
//        echo '<pre>';
//        print_r($assets);
//        echo '</pre>';
//        exit;
             
    }

    /**
     * Adds the given stylesheets to the response object
     *
     * @param array $stylesheets The stylesheets to add to the response
     * @return an array of the stylesheets files just added
     */
    protected function _addStylesheets($stylesheets)
    {
        return $this->_addAssets('Stylesheet', $stylesheets);
    }

    /**
     * Adds the given javascripts to the response object
     *
     * @param array $javascripts The javascripts to add to the response
     * @return an array of the javascripts files just added
     */
    protected function _addJavascripts($javascripts)
    {
        return $this->_addAssets('Javascript', $javascripts);
    }

    /**
     * Runs a series of add$Type statements by parsing the array of assets
     * and figuring out the correct options.
     *
     * The assets array comes straight from app.yml, which has the same
     * format available for view.yml assets
     *
     * The majority of this function taken from sfViewConfigHandler::addAssets()
     *
     * @param string $type Either Stylesheet or Javascript
     */
    protected function _addAssets($type, $assets)
    {
        $method = 'add' . $type;
        $response = $this->_context->getResponse();

        $processedAssets = array();
        foreach ((array) $assets as $key => $asset)
        {
            $position = 'last'; // default position to last
            if (is_array($asset))
            {
                $options = $asset;
                if (isset($asset['position']))
                {
                    $position = $asset['position'];
                    unset($options['position']);
                }
            } else
            {
                $key = $asset;
                $options = array();
            }

            // Keep a full array of the assets and their options
            $processedAssets[] = array('file' => $key, 'position' => $position, 'options' => $options);

            // Keep a simple array of just the assets
            $assetFiles[] = $key;
            // Add the asset to the response
        }

        // Throw an event to allow for paths to be filtered at a low level
        $processedAssets = $this->_context->getEventDispatcher()->filter(
                        new sfEvent($this, 'theme.filter_asset_paths'),
                        $processedAssets
                )->getReturnValue();

        // Add the assets to the response
        $assetFiles = array();
        foreach ($processedAssets as $asset)
        {
            // Add the asset to the response
            $response->$method($asset['file'], $asset['position'], $asset['options']);

            // Record a simple array of the filenames, for returning
            $assetFiles[] = $asset['file'];
        }

        return $assetFiles;
    }

}
