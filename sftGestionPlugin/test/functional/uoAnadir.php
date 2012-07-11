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
    $this->type("id=signin_username", "admin");
    $this->type("id=signin_password", "admin");
    $this->click("id=signin_remember");
    $this->click("css=input[type=\"submit\"]");
    $this->waitForPageToLoad("30000");
    $this->open("/sftprueba/web/index.php/");
    $this->click("link=gestión de uos");
    $this->waitForPageToLoad("30000");
    $this->click("link=Nuevo");
    $this->waitForPageToLoad("30000");
    $this->type("id=sft_uo_codigo", "Test");
    $this->type("id=sft_uo_observaciones", "Test");
    $this->type("id=sft_uo_es_ES_nombre", "Test");
    $this->type("id=sft_uo_en_GB_nombre", "Test");
    $this->click("css=input[type=\"submit\"]");
    $this->waitForPageToLoad("30000");
    $this->click("link=Back to list");
    $this->waitForPageToLoad("30000");
    $this->click("link=Inicio");
    $this->waitForPageToLoad("30000");
  }
}
?>
