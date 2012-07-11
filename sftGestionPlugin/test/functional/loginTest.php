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
  }
}
?>