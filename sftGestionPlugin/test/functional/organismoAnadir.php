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
    $this->click("link=gestión de organismos");
    $this->waitForPageToLoad("30000");
    $this->click("link=Nuevo");
    $this->waitForPageToLoad("30000");
    $this->type("id=sft_organismo_nombre", "Test");
    $this->type("id=sft_organismo_abreviatura", "Test");
    $this->select("id=sft_organismo_id_tipoorganismo", "label=ONG ()");
    $this->type("id=sft_organismo_codigo", "Test");
    $this->type("id=sft_organismo_descripcion", "Test");
    $this->type("id=sft_organismo_sitioweb", "test.test");
    $this->select("id=sft_organismo_id_contacto", "label=Test Test Test");
    $this->type("id=sft_organismo_cargo", "Test");
    $this->type("id=sft_organismo_email", "test@test.test");
    $this->click("css=input[type=\"submit\"]");
    $this->waitForPageToLoad("30000");
    $this->click("link=Back to list");
    $this->waitForPageToLoad("30000");
    $this->click("link=Inicio");
    $this->waitForPageToLoad("30000");
  }
}
?>