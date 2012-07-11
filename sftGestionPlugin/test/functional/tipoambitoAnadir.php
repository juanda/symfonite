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
    $this->click("link=gestión de ámbitos");
    $this->waitForPageToLoad("30000");
    $this->click("link=Nuevo");
    $this->waitForPageToLoad("30000");
    $this->type("id=sft_ambito_tipo_nombre", "Test");
    $this->type("id=sft_ambito_tipo_descripcion", "Test");
    $this->click("css=input[type=\"submit\"]");
    $this->waitForPageToLoad("30000");
    $this->click("link=Back to list");
    $this->waitForPageToLoad("30000");
    $this->click("link=Inicio");
    $this->waitForPageToLoad("30000");
  }
}
?>