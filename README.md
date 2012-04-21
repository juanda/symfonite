SYMFONITE
=========

http://ntic.educacion.es/desarrollo/symfonite/

# Introducción

Symfonite es una extensión del framework de desarrollo de aplicaciones web 
symfony (versión 1.4) con la que se pretende:

* centralizar la gestión de usuarios y perfiles de las aplicaciones construidas
con dicho framework, 

* construir sistemas de aplicaciones web que se pueden asociar/desasociar a los
usuarios a través de una única aplicación de gestión del sistema.

* construir aplicaciones que sean integradas fácilmente en entornos de Identidad
federada.

La extensión consiste en la combinación de varios plugins, algunos de los cuales
han sido desarrollados por el Departamento de Telemática y Desarrollo del
Instituto de Tecnologías Educativas (ITE), y otros son plugins bien conocidos
desarrollados por la comunidad de symfony.

# Instalación y uso
-------------------

Requiere symfony-1.4

* Crear un proyecto de symfony
* Crear una base de datos
* Definir en config/databases.yml los parámetros de conexión a la base de datos (La conexión
  debe llamarse ``sft`` en lugar de ``propel``).
* Descargar el conjunto de plugins *symfonite* en plugins
* Habilitarlos en config/ProjectConfiguration.class.php

Estos son los plugins que debes habilitar:
 
	<?php  
        
        ...	 
  
	class ProjectConfiguration extends sfProjectConfiguration
	{
	  public function setup()
	  {
	      $this->enablePlugins('sfPropelPlugin');
	      $this->enablePlugins('symfonitePlugin');
	      $this->enablePlugins('themesPlugin');
	      $this->enablePlugins('sfGuardPlugin');
	      $this->enablePlugins('sftGuardPlugin');
	      $this->enablePlugins('sfJqueryReloadedPlugin');
	      $this->enablePlugins('sfBreadNav2Plugin');
	      $this->enablePlugins('sftSAMLPlugin');
	      $this->enablePlugins('sftPAPIPlugin');
	      $this->enablePlugins('sftFedIdentMapperPlugin');
	  }

Y ya puedes comenzar a utilizar *symfonite*. Lo mejor es que sigas el tutorial
del sitio http://ntic.educacion.es/desarrollo/symfonite. Allí se explica como
crear la aplicación de administración y su base de datos asociada, y como añadir
y desarrollar nuevas aplicaciones al sistema.
