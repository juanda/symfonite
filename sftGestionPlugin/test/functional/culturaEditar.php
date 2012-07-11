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
    $this->click("link=gestión de culturas");
    $this->waitForPageToLoad("30000");
    $this->click("xpath=(//a[contains(text(),'Editar')])[3]");
    $this->waitForPageToLoad("30000");
    $this->type("id=sft_cultura_nombre", "fl_FL");
    $this->type("id=sft_cultura_descripcion", "Flancia");
    $this->click("css=input[type=\"submit\"]");
    $this->waitForPageToLoad("30000");
    $this->click("link=Back to list");
    $this->waitForPageToLoad("30000");
    $this->click("link=Inicio");
    $this->waitForPageToLoad("30000");
  }
}
?>