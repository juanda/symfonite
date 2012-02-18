<?php
    require_once 'PHPUnit/Framework.php';
    require_once dirname(__FILE__) . '/../../bootstrap/unit.php';

/**
 * Test class for EdaAmbitos
 */

 class EdaAmbitosTest extends PHPUnit_Framework_TestCase {

    protected $object;
    protected $datos = array();

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
      $this->object = new EdaAmbitos();

      $this->datos[0] =  18; // Id
      $this->datos[1] =  1; // Id_ambitotipo
      $this->datos[2] =  1; // Id_periodo
      $this->datos[3] =  'ACTIVO'; // estado {ACTIVO | INACTIVO}

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * testHasOnlyDefaultValues()
     */
    public function testHasOnlyDefaultValues(){

        $this->assertTrue($this->object->hasOnlyDefaultValues());

    }

    /**
     * testGetIdAmbito()
     * Testing that getIdAmbito() returns the Id
     */

    public function testGetIdAmbito() {

        $this->assertEquals($this->object->getId(), $this->object->getIdAmbito());

    }

    /**
     * testToString().
     */
    public function testToString() {

     $nombre  = $this->object->getNombre();
     
     $this->assertEquals($nombre, $this->object->__toString());

    }

 }
?>
