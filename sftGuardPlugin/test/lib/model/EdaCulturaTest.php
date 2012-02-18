<?php
    require_once 'PHPUnit/Framework.php';
    require_once dirname(__FILE__) . '/../../bootstrap/unit.php';

/**
 * Test class for SftDireccion
 */

 class EdaCulturaTest extends PHPUnit_Framework_TestCase {

    protected $object;
    protected $datos = array();

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
      $this->object = new SftCulturas();

      $this->datos[0] =  3; // Id
      $this->datos[1] =  'en_US'; // nombre
      $this->datos[2] = 'USA'; // descripcion

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * testGetIdEmail()
     * Testing that getIdMail() returns the Id
     */
    public function testHasOnlyDefaultValues(){

        $this->assertTrue($this->object->hasOnlyDefaultValues());

    }

    /**
     * testGetIdCultura()
     * Testing that getIdCultura() returns the Id
     */

    public function testgetIdCultura() {

        $this->assertEquals($this->object->getId(), $this->object->getIdCultura());

    }

    /**
     * testToString().
     * must be equal to getDescripcion();
     */
    public function testToString() {

     $this->assertEquals($this->object->getDescripcion(), $this->object->__toString());

    }

 }

?>
