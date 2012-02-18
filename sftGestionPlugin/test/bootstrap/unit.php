<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$_test_dir = realpath(dirname(__FILE__).'/..');
// configuration
require_once dirname(__FILE__).'/../../../../config/ProjectConfiguration.class.php';
$configuration = ProjectConfiguration::hasActive() ? ProjectConfiguration::getActive() : new ProjectConfiguration(realpath($_test_dir.'/../../..'));
// autoloader
$autoload = sfSimpleAutoload::getInstance(sfConfig::get('sf_cache_dir').'/project_autoload.cache');
$autoload->loadConfiguration(sfFinder::type('file')->name('autoload.yml')->in(array(
  sfConfig::get('sf_symfony_lib_dir').'/config/config',
  sfConfig::get('sf_config_dir'),
)));
$autoload->register();

// Conexion con Propel
$configurationPDO = array(
  'propel' => array(
    'datasources' => array(
      'sft' => array(
        'adapter' => 'mysql',
        'connection' => array(
          'dsn' => 'mysql:dbname=sft;host=localhost',
          'user' => 'root',
          'password' => 'root',
          'classname' => 'PropelPDO',
          'options' => array(
            'ATTR_PERSISTENT' => true,
            'ATTR_AUTOCOMMIT' => false,
          ),
          'settings' => array(
            'charset' => array('value' => 'utf8'),
            'queries' => array(),
          ),
        ),
      ),
      'default' => 'propel',
    ),
  ),

 );

Propel::initialize();
Propel::setConfiguration($configurationPDO);

