<?php
    require_once 'PHPUnit/Framework.php';
    require_once dirname(__FILE__) . '/../../bootstrap/unit.php';

/**
 * Test class for SftAcceso
 */

 class SftAccesoTest extends PHPUnit_Framework_TestCase {

    protected $object;
    protected $datos = array();

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
      $this->object = new SftAcceso();

      $this->datos[0] =  18; // Id
      $this->datos[1] =  1; // Id_usuario
      $this->datos[2] =  1; // Id_perfil
      $this->datos[3] =  3; // Id
      $this->datos[4] =  3; // Id
      $this->datos[5] =  3; // Id

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * testHasOnlyDefaultValues(){
     */
    public function testHasOnlyDefaultValues(){

        $this->assertTrue($this->object->hasOnlyDefaultValues());

    }

    /**
     * testGetIdAcceso()
     * Testing that getIdAcceso() returns the Id
     */

    public function testgetIdAcceso() {

        $this->assertEquals($this->object->getId(), $this->object->getIdAcceso());

    }

    /**
     * testToString().
     */
    public function testToString() {

     $object = new SftAcceso();
     
     //$alias  = $object->getEdaUsuarios()->getAlias();
     //$perfil = $object->getEdaPerfiles()->getDescripcion();
     //$uo     = $object->getEdaPerfiles()->getSftUo();
     
     $this->assertEquals("Hola", $object->__toString());

    }



 }

?>