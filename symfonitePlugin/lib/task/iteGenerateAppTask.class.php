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
 * Tarea para generar aplicaciones ITE dentro de un proyecto symfonite
 *
 * Extiende la tarea generate:app propia de symfony  para  generar  aplicaciones
 * ampliadas del tipo  ITE. También  sirve para   generar  la base  de datos que
 * implementa la estructura organizativa, o crear el sistema de autoregistro pa-
 * ra las aplicaciones básicas.
 *
 * Las aplicaciones pueden ser de tres tipos:
 *
 * 1. De administración. Genera tanto la base de datos con la estructura organi-
 *    zativa, como la aplicación de administración para gestionarla.
 * 
 * 2. De registro. Genera la aplicación que permite el auto-registro de usuarios
 *    , a los que se les asignará un perfil que el administrador pueda usar para
 *    darles credenciales en las aplicaciones que desee.
 *  
 * 3. Normal. Genera una aplicación que se autentifica contra la base de datos
 *    anterior. La aplicación proporciona:
 *    - Un diseño por defecto
 *    - El procedimiento de inicio de sesión a partir de una pantalla de login
 *      contra la base de datos.
 *    - Un menú vacío
 *    - Una cabecera con: botones para salir, cambiar de aplicación, cambiar de
 *      perfil, cambiar la configuración personal y ayuda. También presenta el
 *      nombre del usuario que esta registrado, su perfil, UO y periodo
 *
 * Una vez instalado y activado el plugin, se puede consultar las opciones de la
 * tarea mediante:
 * # symfony help generate:appITE
 *
 *
 * @author Juan David Rodríguez <juandavid.rodriguez@ite.educacion.es>
 * @package symfonite
 * @version 1.0
 * @subpackage symfonitePlugin
 */
class iteGenerateAppTask extends sfGenerateAppTask {

    /**
     * Definición de la tarea  (ver documentación de symfony)
     *
     * @see sfTask
     */
    protected function configure() {
        parent::configure();
        $this->name = 'appITE';
        $this->briefDescription = 'Generates a new ITE application';
        $this->addOption('titulo', null, sfCommandOption::PARAMETER_OPTIONAL, 'El titulo de la aplicacion que se ve en la cabecera');
        $this->addOption('clave', null, sfCommandOption::PARAMETER_OPTIONAL, 'la clave de la aplicacion facilitada en el registro de la misma');
        $this->addOption('es_admin', null, sfCommandOption::PARAMETER_OPTIONAL, 'si es_admin=true, se instala el plugin sftGestionPlugin y se habilitan sus módulos para la gestión de la base de datos núcleo');
        $this->addOption('es_registro', null, sfCommandOption::PARAMETER_OPTIONAL, 'si es_registro=true, se instala el plugin sftRegistroPlugin que permite el autoregistro de usuarios');
        $this->addOption('nombre', null, sfCommandOption::PARAMETER_OPTIONAL, 'Si la aplicación es de administración, el nombre con el que se desea registrar (default: Gestión Symfonite)');
        $this->addOption('url', null, sfCommandOption::PARAMETER_OPTIONAL, 'Url de la aplicación');


        $dd = $this->detailedDescription;

        $this->detailedDescription = <<<EOF
Genera una aplicación ITE con:
    - los modulos sftGestorSesion y sftGestorErrores habilitados
    - los parámetros error_404_module, error_404_action, secure_module, secure_action,
                     login_module y login_action adecuadamente definidos
    - la aplicación es segura
    - se define la ruta signing
    - se incluyen las hojas de estilos y javascripts necesarios

Documentacion 'generate:app':
EOF;

        $this->detailedDescription .= $dd;
    }

    /**
     * @see sfTask
     */
    protected function execute($arguments = array(), $options = array()) {


        if (((!isset($options['es_admin']) || $options['es_admin'] != 'true') &&
             (!isset($options['es_registro']) || $options['es_registro'] != 'true')) && !isset($options['clave']) ) {
            throw new sfCommandException(sprintf('Debes indicar la clave de la aplicación.'));
        }

        $app = $arguments['app'];

        // Validate the application name
        if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $app)) {
            throw new sfCommandException(sprintf('The application name "%s" is invalid.', $app));
        }

        $appDir = sfConfig::get('sf_apps_dir') . '/' . $app;

        if (is_dir($appDir)) {
            throw new sfCommandException(sprintf('The application "%s" already exists.', $appDir));
        }

        if (is_readable(sfConfig::get('sf_data_dir') . '/skeleton/appITE')) {
            $skeletonDir = sfConfig::get('sf_data_dir') . '/skeleton/appITE';
        } else {
            $skeletonDir = dirname(__FILE__) . '/skeleton/appITE';
        }

        // Create basic application structure
        $finder = sfFinder::type('any')->discard('.sf');
        $this->getFilesystem()->mirror($skeletonDir . '/app', $appDir, $finder);

        // Create $app.php or index.php if it is our first app
        $indexName = 'index';
        $firstApp = !file_exists(sfConfig::get('sf_web_dir') . '/index.php');
        if (!$firstApp) {
            $indexName = $app;
        }

        if (true === $options['csrf-secret']) {
            $options['csrf-secret'] = sha1(rand(111111111, 99999999) . getmypid());
        }

// Set no_script_name value in settings.yml for production environment
        $finder = sfFinder::type('file')->name('settings.yml');
        $this->getFilesystem()->replaceTokens($finder->in($appDir . '/config'), '##', '##', array(
            'NO_SCRIPT_NAME' => $firstApp ? 'true' : 'false',
            'CSRF_SECRET' => sfYamlInline::dump(sfYamlInline::parseScalar($options['csrf-secret'])),
            'ESCAPING_STRATEGY' => sfYamlInline::dump((boolean) sfYamlInline::parseScalar($options['escaping-strategy'])),
            'USE_DATABASE' => sfConfig::has('sf_orm') ? 'true' : 'false',
        ));

        $this->getFilesystem()->copy($skeletonDir . '/web/index.php', sfConfig::get('sf_web_dir') . '/' . $indexName . '.php');
        $this->getFilesystem()->copy($skeletonDir . '/web/index.php', sfConfig::get('sf_web_dir') . '/' . $app . '_dev.php');

        $this->getFilesystem()->replaceTokens(sfConfig::get('sf_web_dir') . '/' . $indexName . '.php', '##', '##', array(
            'APP_NAME' => $app,
            'ENVIRONMENT' => 'prod',
            'IS_DEBUG' => 'false',
            'IP_CHECK' => '',
        ));

        $this->getFilesystem()->replaceTokens(sfConfig::get('sf_web_dir') . '/' . $app . '_dev.php', '##', '##', array(
            'APP_NAME' => $app,
            'ENVIRONMENT' => 'dev',
            'IS_DEBUG' => 'true',
                /* 'IP_CHECK'    => '// this check prevents access to debug front controllers that are deployed by accident to production servers.'.PHP_EOL.
                  '// feel free to remove this, extend it or make something more sophisticated.'.PHP_EOL.
                  'if (!in_array(@$_SERVER[\'REMOTE_ADDR\'], array(\'127.0.0.1\',\'10.200.16.%\', \'::1\')))'.PHP_EOL.
                  '{'.PHP_EOL.
                  '  die(\'You are not allowed to access this file. Check \'.basename(__FILE__).\' for more information.\');'.PHP_EOL.
                  '}'.PHP_EOL, */
        ));

        $this->getFilesystem()->rename($appDir . '/config/ApplicationConfiguration.class.php', $appDir . '/config/' . $app . 'Configuration.class.php');

        $this->getFilesystem()->replaceTokens($appDir . '/config/' . $app . 'Configuration.class.php', '##', '##', array('APP_NAME' => $app));


        $fixPerms = new sfProjectPermissionsTask($this->dispatcher, $this->formatter);
        $fixPerms->setCommandApplication($this->commandApplication);
        $fixPerms->setConfiguration($this->configuration);
        $fixPerms->run();

// Create test dir
        $this->getFilesystem()->mkdirs(sfConfig::get('sf_test_dir') . '/functional/' . $app);


// código propio de appITE

        $options['orm'] = (file_exists('./config/propel.ini')) ? 'Propel' : 'Doctrine';

        if ($options['orm'] == 'Propel') {
            $this->runTask('propel:build-model');
            $this->runTask('propel:build-forms');
            $this->runTask('propel:build-filters');
        } else {
            $this->runTask('doctrine:build-model');
            $this->runTask('doctrine:build-forms');
            $this->runTask('doctrine:build-filters');
        }

        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase('sft')->getConnection();

        $titulo = isset($options['titulo']) ? $options['titulo'] : 'Título aplicación';
        $clave = isset($options['clave']) ? $options['clave'] : '';
        $url = isset($options['url']) ? $options['url'] : 'http://localhost/sft/web/' . $app .".php";

        $this->getFilesystem()->replaceTokens($appDir . '/config/app.yml', '##', '##', array('TITULO' => $titulo));
//
        $this->getFilesystem()->replaceTokens($appDir . '/config/app.yml', '##', '##', array('TITULO' => $titulo));
        if ((!isset($options['es_admin']) || $options['es_admin'] != 'true') &&
            (!isset($options['es_registro']) || $options['es_registro'] != 'true')) {
            $aplicacion = SftAplicacionPeer::dameAplicacionConClave($clave);

            if ($aplicacion instanceof SftAplicacion) {
                $credencialDeAcceso = $aplicacion->getSftCredencial();
                if (!$credencialDeAcceso instanceof SftCredencial) {
                    throw new sfCommandException(sprintf('Error!, la aplicación no tiene asignada la credencial de acceso!!'));
                }
            } else {
                throw new sfCommandException(sprintf('La aplicación no está registrada. (No hay en el sistema ninguna aplicación con esa clave)'));
            }
            $this->getFilesystem()->replaceTokens($appDir . '/config/security.yml', '##', '##', array('CREDENCIAL' => $credencialDeAcceso->getNombre()));
            $this->getFilesystem()->replaceTokens($appDir . '/config/routing.yml', '##', '##', array('MODHOMEPAGE' => 'inicio'));
            $this->getFilesystem()->replaceTokens($appDir . '/config/routing.yml', '##', '##', array('ACCHOMEPAGE' => 'homepage'));
            $this->getFilesystem()->replaceTokens($appDir . '/config/app.yml', '##', '##', array('CLAVE' => $clave));
            $this->getFilesystem()->replaceTokens($appDir . '/config/app.yml', '##', '##', array('CODIGO' => $aplicacion->getCodigo()));
            $this->getFilesystem()->replaceTokens($appDir . '/config/factories.yml', '##', '##', array('SESION' => $aplicacion->getCodigo()));
        }
        if ($options['es_registro'] == 'true') {
            $nombre = ($nombre == '') ? 'Registro en Symfonite' : $nombre;
            $clave = ($clave == '') ? 'claveaux' : $clave;

            // Habilitamos el plugin de gestión
            $this->enablePlugin('sftRegistroPlugin');

            $settings = sfYaml::load('./apps/' . $app . '/config/settings.yml');
            array_push($settings['all']['.settings']['enabled_modules'], 'registro');

            $settings_yml = sfYaml::dump($settings);

            $this->getFilesystem()->remove('./apps/' . $app . '/config/settings.yml');
            $fp = fopen('./apps/' . $app . '/config/settings.yml', 'wb');
            fwrite($fp, $settings_yml);


            //alta aplicación

            $textoIntro = <<< END
Esta aplicación permite el autoregistro de usuarios en Symfonite, dándoles un perfil básico qué el administrador utilizará para darles permisos en distintas aplicaciones.
END;
            $aplicacion = new SftAplicacion();
            $aplicacion->setCodigo($arguments['app']);
            $aplicacion->setNombre($nombre);
            $aplicacion->setDescripcion('Aplicación de registro en symfonite');
            $aplicacion->setEsSymfonite(true);
            $aplicacion->setUrl($url);
            $aplicacion->setClave($clave);
            $aplicacion->setTextoIntro($textoIntro);

            $aplicacion->save();

            //alta credencial de acceso a la aplicación
            $credencial = new SftCredencial();
            $credencial->setIdAplicacion($aplicacion->getId());
            $credencial->setNombre($aplicacion->getCodigo() . '_ACCESO');
            $credencial->setDescripcion('Credencial de acceso a la aplicación:' . $nombre);

            $credencial->save();

            $aplicacion->setIdCredencial($credencial->getId());
            $aplicacion->save();


            // alta UO
            $uo = new SftUo();
            $uo->setCodigo('UO1');
            $uo->setNombre('UO Registro', 'es_ES');
            $uo->setNombre('Register UO', 'en_GB');

            $uo->save();

            // alta periodo

            $periodo = new SftPeriodo();
            $periodo->setIdUo($uo->getId());
            $periodo->setFechainicio(date('Y-m-d'));
            $periodo->setEstado('ACTIVO');
            $periodo->setDescripcion('Registro');

            $periodo->save();

            // alta perfil

            $perfil = new SftPerfil();
            $perfil->setIdUo($uo->getId());
            $perfil->setNombre('Invitado', 'es_ES');
            $perfil->setNombre('Guest', 'en_GB');
            $perfil->setAbreviatura('Inv', 'es_ES');
            $perfil->setAbreviatura('Gst', 'en_GB');

            $perfil->save();

            // asociacion perfil - credencial

            $perfil_credencial = new SftPerfilCredencial();
            $perfil_credencial->setIdPerfil($perfil->getId());
            $perfil_credencial->setIdCredencial($credencial->getId());

            $perfil_credencial->save();

            $this->getFilesystem()->replaceTokens($appDir . '/config/security.yml', '##', '##', array('CREDENCIAL' => $credencial->getNombre()));
            $this->getFilesystem()->replaceTokens($appDir . '/config/routing.yml', '##', '##', array('MODHOMEPAGE' => 'inicio'));
            $this->getFilesystem()->replaceTokens($appDir . '/config/routing.yml', '##', '##', array('ACCHOMEPAGE' => 'homepage'));
            $this->getFilesystem()->replaceTokens($appDir . '/config/app.yml', '##', '##', array('CLAVE' => $clave));
            $this->getFilesystem()->replaceTokens($appDir . '/config/app.yml', '##', '##', array('CODIGO' => $aplicacion->getCodigo()));
            $this->getFilesystem()->replaceTokens($appDir . '/config/factories.yml', '##', '##', array('SESION' => $aplicacion->getCodigo()));

            $app_settings = sfYaml::load('./apps/' . $app . '/config/app.yml');
            $app_settings['all']['password_expire'] = 30;
            $app_settings['all']['registro_enabled'] = true;
            $app_settings['all']['id_periodo_inicial'] = $periodo->getId();
            $app_settings['all']['id_perfil_inicial'] = $perfil->getId();

            $settings_yml = sfYaml::dump($app_settings);

            $this->getFilesystem()->remove('./apps/' . $app . '/config/app.yml');
            $fp = fopen('./apps/' . $app . '/config/app.yml', 'wb');
            fwrite($fp, $settings_yml);
            
            $this->log('##############################################################################################################');
            $this->logSection('Registro:', 'Recuerda modificar el mailer en el archivo factories.yml de la carpeta /conf de la aplicación para 
añadirle los datos de tu servidor de correo');
            $this->log('##############################################################################################################');
        }elseif ($options['es_admin'] == 'true') {
            $nombre = ($nombre == '') ? 'Gestión Symfonite' : $nombre;
            $clave = ($clave == '') ? 'cambiar' : $clave;

            // Habilitamos el plugin de gestión
            $this->enablePlugin('sftGestionPlugin');

            $settings = sfYaml::load('./apps/' . $app . '/config/settings.yml');
            array_push($settings['all']['.settings']['enabled_modules'], 'periodo');
            array_push($settings['all']['.settings']['enabled_modules'], 'uo');
            array_push($settings['all']['.settings']['enabled_modules'], 'perfil');
            array_push($settings['all']['.settings']['enabled_modules'], 'ambito');
            array_push($settings['all']['.settings']['enabled_modules'], 'aplicacion');
            array_push($settings['all']['.settings']['enabled_modules'], 'credencial');
            array_push($settings['all']['.settings']['enabled_modules'], 'asociacredenciales');
            array_push($settings['all']['.settings']['enabled_modules'], 'cultura');
            array_push($settings['all']['.settings']['enabled_modules'], 'persona');
            array_push($settings['all']['.settings']['enabled_modules'], 'email');
            array_push($settings['all']['.settings']['enabled_modules'], 'telefono');
            array_push($settings['all']['.settings']['enabled_modules'], 'direccion');
            array_push($settings['all']['.settings']['enabled_modules'], 'asociaperfiles');
            array_push($settings['all']['.settings']['enabled_modules'], 'atributo');
            array_push($settings['all']['.settings']['enabled_modules'], 'asociaatributos');
            array_push($settings['all']['.settings']['enabled_modules'], 'tipodoc');
            array_push($settings['all']['.settings']['enabled_modules'], 'organismo');
            array_push($settings['all']['.settings']['enabled_modules'], 'tipodir');
            array_push($settings['all']['.settings']['enabled_modules'], 'tipodoc');
            array_push($settings['all']['.settings']['enabled_modules'], 'tipoorg');
            array_push($settings['all']['.settings']['enabled_modules'], 'tipotel');
            array_push($settings['all']['.settings']['enabled_modules'], 'pais');
            array_push($settings['all']['.settings']['enabled_modules'], 'comunidad');
            array_push($settings['all']['.settings']['enabled_modules'], 'provincia');
            array_push($settings['all']['.settings']['enabled_modules'], 'ambitotipo');
            array_push($settings['all']['.settings']['enabled_modules'], 'asociaambitos');
            array_push($settings['all']['.settings']['enabled_modules'], 'sfGuardUser');
            array_push($settings['all']['.settings']['enabled_modules'], 'sfGuardGroup');
            array_push($settings['all']['.settings']['enabled_modules'], 'sfGuardPermission');
            array_push($settings['all']['.settings']['enabled_modules'], 'sfBreadNavAdmin');
            array_push($settings['all']['.settings']['enabled_modules'], 'sftPAPIAdmin');
            array_push($settings['all']['.settings']['enabled_modules'], 'sftSAMLAdmin');
            array_push($settings['all']['.settings']['enabled_modules'], 'attrmapperadmin');
            array_push($settings['all']['.settings']['enabled_modules'], 'fid_asociaperfiles');
            array_push($settings['all']['.settings']['enabled_modules'], 'fid_asociaambitos');
            array_push($settings['all']['.settings']['enabled_modules'], 'fid_mapping');
            

            $settings_yml = sfYaml::dump($settings);

            $this->getFilesystem()->remove('./apps/' . $app . '/config/settings.yml');
            $fp = fopen('./apps/' . $app . '/config/settings.yml', 'wb');
            fwrite($fp, $settings_yml);

            // Definimos la homepage
            // Creamos el menu

            $this->getFileSystem()->copy('./plugins/sftGestionPlugin/config/menus/menu.yml', './apps/' . $app . '/config/menus/root.yml');

            // creamos las tablas de la base de dato. La base de datos debe estar creada

            $this->runTask('propel:build-sql');
            $this->runTask('propel:insert-sql');


            //alta aplicación

            $textoIntro = <<< END
<p>Esta aplicación permite administrar toda la estructura de organizativa de tu centro:</p><ul><li>Las Unidades Organizativas (departamentos, por ejemplo)</li><li>Los perfiles asociados a cada unidad (administradores, contables, profesores ...)</li><li>Los ámbitos de trabajo de cada perfil (cursos para los profesores, por ejemplo)</li><li>Los periodos de funcionamiento (ejercicios académicos, por ejemplo)</li></ul><br/><p>También sirve para registrar las aplicaciones que se acoplen al sistema, para asociarlas a los perfiles que las necesiten y para construir sus menús.</p><p>Y por último, puedes gestionar tus usuarios asignándoles los perfiles que precisen.</p><p>Puedes cambiar este mensaje de introducción a través del menú <i>Aplicaciones</i> de esta misma aplicación.</p>
END;
            $aplicacion = new SftAplicacion();
            $aplicacion->setCodigo($arguments['app']);
            $aplicacion->setNombre($nombre);
            $aplicacion->setDescripcion('Administración del Núcleo');
            $aplicacion->setEsSymfonite(true);
            $aplicacion->setUrl($url);
            $aplicacion->setClave($clave);
            $aplicacion->setTextoIntro($textoIntro);

            $aplicacion->save();

            //alta credencial de acceso a la aplicación
            $credencial = new SftCredencial();
            $credencial->setIdAplicacion($aplicacion->getId());
            $credencial->setNombre($aplicacion->getCodigo() . '_ACCESO');
            $credencial->setDescripcion('Credencial de acceso a la aplicación:' . $nombre);

            $credencial->save();

            $aplicacion->setIdCredencial($credencial->getId());
            $aplicacion->save();

            // alta credencial de administración total del plugin sftGestionPlugin
            $credencial_admon = new SftCredencial();
            $credencial_admon->setIdAplicacion($aplicacion->getId());
            $credencial_admon->setNombre('SFTGESTIONPLUGIN_administracion');
            $credencial_admon->setDescripcion('Administración completa de la aplicación:' . $nombre);

            $credencial_admon->save();

            // alta credencial de administración desde una UO particular del plugin sftGestionPlugin
            $credencial_admon_uo = new SftCredencial();
            $credencial_admon_uo->setIdAplicacion($aplicacion->getId());
            $credencial_admon_uo->setNombre('SFTGESTIONPLUGIN_administracion_uo');
            $credencial_admon_uo->setDescripcion('Administración parcial de la aplicación:' . $nombre);

            $credencial_admon_uo->save();


            // alta UO
            $uo = new SftUo();
            $uo->setCodigo('UO0');
            $uo->setNombre('UO Administración', 'es_ES');
            $uo->setNombre('Administration UO', 'en_GB');

            $uo->save();

            // alta periodo

            $periodo = new SftPeriodo();
            $periodo->setIdUo($uo->getId());
            $periodo->setFechainicio(date('Y-m-d'));
            $periodo->setEstado('ACTIVO');
            $periodo->setDescripcion('Administración');

            $periodo->save();

            // alta perfil

            $perfil = new SftPerfil();
            $perfil->setIdUo($uo->getId());
            $perfil->setNombre('SuperAdministrador', 'es_ES');
            $perfil->setNombre('SuperAdministrator', 'en_GB');
            $perfil->setAbreviatura('SuperAdmin', 'es_ES');
            $perfil->setAbreviatura('SuperAdmin', 'en_GB');

            $perfil->save();

            // asociacion perfil - credencial

            $perfil_credencial = new SftPerfilCredencial();
            $perfil_credencial->setIdPerfil($perfil->getId());
            $perfil_credencial->setIdCredencial($credencial->getId());

            $perfil_credencial->save();

            $perfil_credencial = new SftPerfilCredencial();
            $perfil_credencial->setIdPerfil($perfil->getId());
            $perfil_credencial->setIdCredencial($credencial_admon->getId());

            $perfil_credencial->save();

            $perfil_credencial = new SftPerfilCredencial();
            $perfil_credencial->setIdPerfil($perfil->getId());
            $perfil_credencial->setIdCredencial($credencial_admon_uo->getId());

            $perfil_credencial->save();


            // alta persona, cuando se da de alta la persona, también se
            // da de alta el SftUsuarios y el SfGuardUser

            $persona = new SftPersona();
            $persona->setNombre('root');

            $persona->save();

            // alta acceso

            $usuarios = $persona->getSftUsuarios();
            $sfUser = $usuarios[0]->dameSfGuardUser();
            $sfUser->setUsername('admin');
            $sfUser->setPassword('admin');
            $sfUser->save();
            $acceso = new SftAcceso();
            $acceso->setIdUsuario($usuarios[0]->getId());
            $acceso->setIdPerfil($perfil->getId());
            $acceso->setEsinicial(1);

            $acceso->save();

            // alta configuracion personal
            $confPersonal = new SftConfPersonal();
            $confPersonal->setIdUsuario($usuarios[0]->getId());
            $confPersonal->setIdAplicacion($aplicacion->getId());
            $confPersonal->setIdPeriodo($periodo->getId());
            $confPersonal->setIdPerfil($perfil->getId());

            $confPersonal->save();

            // alta culturas

            $cultura1 = new SftCultura();
            $cultura1->setNombre('es_ES');
            $cultura1->setDescripcion('Español');

            $cultura1->save();

            $cultura2 = new SftCultura();
            $cultura2->setNombre('en_GB');
            $cultura2->setDescripcion('English');

            $cultura2->save();

            // alta menu
            $menu = new sfBreadNavApplication();
            $menu->setApplication($arguments['app']);
            $menu->setName('menu_' . $arguments['app']);
            $menu->save();

            $menus = sfYaml::load('./apps/' . $app . '/config/menus/root.yml');

            $itemInicio = new sfBreadNav();
            $itemInicio->setPage($menus['page']);
            $itemInicio->setModule($menus['module']);
            $itemInicio->setAction($menus['action']);
            $itemInicio->setCredential($menus['credential']);
            $itemInicio->setTreeLeft(1);
            $itemInicio->setTreeRight(2);
            $itemInicio->setTreeParent(0);
            $itemInicio->setScope($menu->getId());

            $itemInicio->save();

            //require_once(sfConfig::get('sf_plugins_dir').'/sfBreadNav2Plugin/modules/sfBreadNavAdmin/lib/sfBreadNavAddPageForm.class.php');
            foreach ($menus['menu'] as $menu1) {
                $values = array();
                $values['page'] = $menu1['page'];
                $values['module'] = $menu1['module'];
                $values['action'] = $menu1['action'];
                $values['credential'] = $menu1['credential'];
                $values['order'] = -1;
                $values['order_option'] = 'below';
                $values['parent'] = -1;

                sfBreadNavPeer::addPage($values, $menu->getId());

                $c = new Criteria();
                $c->add(sfBreadNavPeer::PAGE, $menu1['page']);
                $objMenu1 = sfBreadNavPeer::doSelectOne($c);


                foreach ($menu1['menu'] as $menu2) {
                    $values = array();
                    $values['page'] = $menu2['page'];
                    $values['module'] = $menu2['module'];
                    $values['action'] = $menu2['action'];
                    $values['credential'] = $menu2['credential'];
                    $values['order'] = -1;
                    $values['order_option'] = 'below';
                    $values['parent'] = $objMenu1->getId();

                    sfBreadNavPeer::addPage($values, $menu->getId());
                }
            }

            $this->getFilesystem()->replaceTokens($appDir . '/config/security.yml', '##', '##', array('CREDENCIAL' => $credencial->getNombre()));
            $this->getFilesystem()->replaceTokens($appDir . '/config/routing.yml', '##', '##', array('MODHOMEPAGE' => 'inicio'));
            $this->getFilesystem()->replaceTokens($appDir . '/config/routing.yml', '##', '##', array('ACCHOMEPAGE' => 'homepage'));
            $this->getFilesystem()->replaceTokens($appDir . '/config/app.yml', '##', '##', array('CLAVE' => $clave));
            $this->getFilesystem()->replaceTokens($appDir . '/config/app.yml', '##', '##', array('CODIGO' => $aplicacion->getCodigo()));
            $this->getFilesystem()->replaceTokens($appDir . '/config/factories.yml', '##', '##', array('SESION' => $aplicacion->getCodigo()));
        }

        $this->log('OK Mackey ;-)');
    }

}
