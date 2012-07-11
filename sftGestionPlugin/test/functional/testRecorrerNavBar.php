<?php
class testRecorrerNavBar extends PHPUnit_Extensions_SeleniumTestCase {

    protected function setUp() {
        $this->setBrowser("*chrome");
        $this->setBrowserUrl("http://localhost/");
    }

    public function testMyTestCase() {
        $this->open("/sft/web/index.php");
        $this->type("id=signin_username", "admin");
        $this->type("id=signin_password", "admin");
        $this->click("css=input[type=\"submit\"]");
        $this->waitForPageToLoad("30000");
        $this->click("link=Inicio");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Página de inicio"), 'No se ha llegado a la página de inicio al navegar por la NabBar y hacer click en "Inicio"');
        $this->click("link=UOS");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Unidades Organizativas"), 'No se ha llegado a la página de "Listado de Unidades Organizativas" al navegar por la NabBar y hacer click en "UOS"');
        $this->click("link=Gestión de uos");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Unidades Organizativas"), 'No se ha llegado a la página de "Listado de Unidades Organizativas" al navegar por la NabBar y hacer click en "Gestión de uos"');
        $this->click("link=Gestión de periodos");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Periodos"), 'No se ha llegado a la página de "Listado de Periodos" al navegar por la NabBar y hacer click en "Gestión de periodos"');
        $this->click("link=Gestión de perfiles");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Perfiles"), 'No se ha llegado a la página de "Listado de Perfiles" al navegar por la NabBar y hacer click en "Gestión de perfiles"');
        $this->click("link=Gestión de ámbitos");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Tipos de Ámbitos"), 'No se ha llegado a la página de "Listado de Tipos de Ámbitos" al navegar por la NabBar y hacer click en "Gestión de ámbitos"');
        $this->click("link=Usuarios");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Personas"), 'No se ha llegado a la página de "Listado de Personas" al navegar por la NabBar y hacer click en "Usuarios"');
        $this->click("link=Gestión de personas");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Personas"), 'No se ha llegado a la página de "Listado de Personas" al navegar por la NabBar y hacer click en "Gestión de personas"');
        $this->click("link=Gestión de organismos");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Organismos"), 'No se ha llegado a la página de "Listado de Organismos" al navegar por la NabBar y hacer click en "Gestión de organismos"');
        $this->click("link=Aplicaciones");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Aplicaciones"), 'No se ha llegado a la página de "Listado de Aplicaciones" al navegar por la NabBar y hacer click en "Aplicaciones"');
        $this->click("link=Gestión de aplicaciones");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Aplicaciones"), 'No se ha llegado a la página de "Listado de Aplicaciones" al navegar por la NabBar y hacer click en "Gestión de aplicaciones"');
        $this->click("link=Gestión de culturas");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Culturas"), 'No se ha llegado a la página de "Listado de Culturas" al navegar por la NabBar y hacer click en "Gestión de culturas"');
        $this->click("link=Localizaciones");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Países"), 'No se ha llegado a la página de "Listado de Países" al navegar por la NabBar y hacer click en "Localizaciones"');
        $this->click("link=Gestión países");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Países"), 'No se ha llegado a la página de "Listado de Países" al navegar por la NabBar y hacer click en "Gestión países"');
        $this->click("link=Gestión de comunidades");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Comunidades"), 'No se ha llegado a la página de "Listado de Comunidades" al navegar por la NabBar y hacer click en "Gestión de comunidades"');
        $this->click("link=Gestión de provincias");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Provincias"), 'No se ha llegado a la página de "Listado de Provincias" al navegar por la NabBar y hacer click en "Gestión de provincias"');
        $this->click("link=Datos Auxiliares");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de tipos de documentos de identificación"), 'No se ha llegado a la página de "Listado de tipos de documentos de identificación" al navegar por la NabBar y hacer click en "Datos Auxiliares"');
        $this->click("link=Gestión de tipos de documentos");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de tipos de documentos de identificación"), 'No se ha llegado a la página de "Listado de tipos de documentos de identificación" al navegar por la NabBar y hacer click en "Gestión de tipos de documentos"');
        $this->click("link=Gestión de tipos de direcciones");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Tipos de Direcciones"), 'No se ha llegado a la página de "Listado de Tipos de Direcciones" al navegar por la NabBar y hacer click en "Gestión de tipos de direcciones"');
        $this->click("link=Gestión de tipos de organismos");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Tipos de Organismos"), 'No se ha llegado a la página de "Listado de Tipos de Organismos" al navegar por la NabBar y hacer click en "Gestión de tipos de organismos"');
        $this->click("link=Gestión de tipos de telefonos");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Tipos de Teléfonos"), 'No se ha llegado a la página de "Listado de Tipos de Organismos" al navegar por la NabBar y hacer click en "Gestión de tipos de telefonos"');
        $this->click("link=Gestión de atributos");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Listado de Atributos"), 'No se ha llegado a la página de "Listado de Atributos" al navegar por la NabBar y hacer click en "Gestión de atributos"');
        $this->click("link=Identidad Federada");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Parámetros del Punto de Acceso (PoA)"), 'No se ha llegado a la página de "Parámetros del Punto de Acceso (PoA)" al navegar por la NabBar y hacer click en "Identidad Federada"');
        $this->click("link=Gestión del PoA PAPI");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isTextPresent("Parámetros del Punto de Acceso (PoA)"), 'No se ha llegado a la página de "Parámetros del Punto de Acceso (PoA)" al navegar por la NabBar y hacer click en "Gestión del PoA PAPI"');
        $this->click("link=Gestión de simpleSAMLphp");
        $this->waitForPageToLoad("30000");
    }

}

?>