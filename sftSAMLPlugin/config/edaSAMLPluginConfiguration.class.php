<?php

class edaSAMLPluginConfiguration extends sfPluginConfiguration
{
    public function initialize()
    {
        require_once dirname(__FILE__).'/../lib/vendor/simplesamlphp-1.8.0-rc1/lib/_autoload.php';
        //sfConfig::set('sf_factory_storage_class', 'SAMLsfSessionStorage');
    }
}
