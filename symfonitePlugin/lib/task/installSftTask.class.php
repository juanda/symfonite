<?php

class installSftTask extends sfBaseTask
{

    protected function configure()
    {
        // // add your own arguments here
        // $this->addArguments(array(
        //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
        // ));

        $this->addOptions(array(
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
                // add your own options here
        ));

        $this->namespace = 'project';
        $this->name = 'installSft';
        $this->briefDescription = 'Install and configure symfonite framework';
        $this->detailedDescription = <<<EOF
The [installSftTask|INFO] task install and configure the symmfonite framework

  [php symfony installSftTask|INFO]
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        // initialize the database connection
//    $databaseManager = new sfDatabaseManager($this->configuration);
//    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
        $fs = new sfFilesystem();
        
        if(!file_exists(dirname(__FILE__).'/../../../../cache'))
        {
            $fs->mkdirs(dirname(__FILE__).'/../../../../cache');
        }
        
        if(!file_exists(dirname(__FILE__).'/../../../../log'))
        {
            $fs->mkdirs(dirname(__FILE__).'/../../../../log');
        }
        
        if(!file_exists(dirname(__FILE__).'/../../../../web/uploads'))
        {
            $fs->mkdirs(dirname(__FILE__).'/../../../../web/uploads');
        }
        
        if(!file_exists(dirname(__FILE__).'/../../../../uploads/assets'))
        {
            $fs->mkdirs(dirname(__FILE__).'/../../../../web/uploads/assets');
        }
        
        if(!file_exists(dirname(__FILE__).'/../../../../web/images'))
        {
            $fs->mkdirs(dirname(__FILE__).'/../../../../web/images');
        }
        
        if(!file_exists(dirname(__FILE__).'/../../../../web/js'))
        {
            $fs->mkdirs(dirname(__FILE__).'/../../../../web/js');
        }
        
        
        $this->runTask('project:permission');
        $this->runTask('plugin:publish-assets');

        $files = array(
            dirname(__FILE__) . '/../../../sftSAMLPlugin/lib/vendor/simplesamlphp-1.8.0-rc1/config/config.php',
            dirname(__FILE__) . '/../../../sftSAMLPlugin/lib/vendor/simplesamlphp-1.8.0-rc1/metadata',
            dirname(__FILE__) . '/../../../sftSAMLPlugin/lib/vendor/simplesamlphp-1.8.0-rc1/metadata/saml20-sp-remote.php',
            dirname(__FILE__) . '/../../../sftSAMLPlugin/lib/vendor/simplesamlphp-1.8.0-rc1/metadata/saml20-idp-remote.php',
            dirname(__FILE__) . '/../../../sftPAPIPlugin/lib/vendor/phpPoA-2.3/PAPI.conf',
            dirname(__FILE__) . '/../../../sftPAPIPlugin/lib/vendor/phpPoA-2.3/pubkey.pem',
        );

        //print_r($files);
        $fs->chmod($files, 0777);

        $originDir = dirname(__FILE__) . '/../../../sftSAMLPlugin/lib/vendor/simplesamlphp-1.8.0-rc1/www';
        $targetDir = dirname(__FILE__) . '/../../../../web/simplesaml';
        //print_r($originDir);
        //print_r($targetDir);

        $fs->relativeSymlink($originDir, $targetDir, true);

        // add your code here
    }

}
