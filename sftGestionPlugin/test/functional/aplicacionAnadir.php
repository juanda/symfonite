<?php
class Example extends PHPUnit_Extensions_SeleniumTestCase
{
  protected function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl("http://localhost/sftprueba/web/index.php/");
  }

  public function testMyTestCase()
  {
    $this->open("/sftprueba/web/index.php/");
    $this->click("link=gestión de aplicaciones");
    $this->waitForPageToLoad("30000");
    $this->click("link=Nuevo");
    $this->waitForPageToLoad("30000");
    $this->type("id=sft_aplicacion_codigo", "test");
    $this->type("id=sft_aplicacion_nombre", "Test");
    $this->type("id=sft_aplicacion_descripcion", "Test");
    $this->type("id=sft_aplicacion_texto_intro", "Test");
    $this->click("id=sft_aplicacion_es_symfonite");
    $this->type("id=sft_aplicacion_url", "test.test");
    $this->click("link=generar clave");
    $this->click("css=input[type=\"submit\"]");
    $this->waitForPageToLoad("30000");
    $this->click("link=Back to list");
    $this->waitForPageToLoad("30000");
    $this->click("link=Inicio");
    $this->waitForPageToLoad("30000");
  }
}
?>