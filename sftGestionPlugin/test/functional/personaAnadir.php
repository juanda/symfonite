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
    $this->click("link=gestión de personas");
    $this->waitForPageToLoad("30000");

    for($i = 0; $i < 500; $i++){
	    $this->click("link=Nuevo");
	    $this->waitForPageToLoad("30000");
	    $this->type("id=sft_persona_nombre", "Test");
	    $this->type("id=sft_persona_apellido2", "Test");
	    $this->type("id=sft_persona_apellido1", "Test");
	    $this->type("id=sft_persona_email", "test@test.test");
	    $this->select("id=sft_persona_id_tipodocidentificacion", "label=DNI");
	    $this->type("id=sft_persona_docidentificacion", "11111111A");
	    $this->select("id=sft_persona_fechanacimiento_month", "label=01");
	    $this->select("id=sft_persona_fechanacimiento_day", "label=01");
	    $this->select("id=sft_persona_fechanacimiento_year", "label=1900");
	    $this->type("id=sft_persona_observaciones", "Test");
	    $this->type("id=sft_persona_profesion", "Test");
	    $this->click("css=input[type=\"submit\"]");
	    $this->waitForPageToLoad("30000");
	    $this->click("link=Back to list");
	    $this->waitForPageToLoad("30000");
	}


    $this->click("link=Inicio");
    $this->waitForPageToLoad("30000");

  }
}
?>
