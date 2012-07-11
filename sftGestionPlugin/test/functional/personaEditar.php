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
    $this->click("link=gestión de personas");
    $this->waitForPageToLoad("30000");
    $this->click("xpath=(//a[contains(text(),'Editar')])[2]");
    $this->waitForPageToLoad("30000");
    $this->type("id=sft_persona_nombre", "Test1");
    $this->type("id=sft_persona_apellido1", "Test1");
    $this->type("id=sft_persona_apellido2", "Test1");
    $this->type("id=sft_persona_profesion", "Test1");
    $this->type("id=sft_persona_observaciones", "Test1");
    $this->type("id=sft_persona_docidentificacion", "11111111B");
    $this->select("id=sft_persona_sexo", "label=M");
    $this->click("css=input[type=\"submit\"]");
    $this->waitForPageToLoad("30000");
    $this->click("link=Back to list");
    $this->waitForPageToLoad("30000");
    $this->click("link=Inicio");
    $this->waitForPageToLoad("30000");
  }
}
?>