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
    $this->click("link=gestión de perfiles");
    $this->waitForPageToLoad("30000");
    $this->click("link=Nuevo");
    $this->waitForPageToLoad("30000");
    $this->select("id=sft_perfil_id_uo", "label=Test");
    $this->type("id=sft_perfil_codigo", "Test");
    $this->type("id=sft_perfil_menu", "Test");
    $this->type("id=sft_perfil_es_ES_nombre", "Test");
    $this->type("id=sft_perfil_en_GB_nombre", "Test");
    $this->click("css=input[type=\"submit\"]");
    $this->waitForPageToLoad("30000");
    $this->click("link=Back to list");
    $this->waitForPageToLoad("30000");
    $this->click("link=Inicio");
    $this->waitForPageToLoad("30000");
  }
}
?>