<?php

    require_once 'PHPUnit/Framework.php';    
    require_once dirname(__FILE__) . '/../../bootstrap/unit.php';

     /**
     * Test class for SftAccesoAmbito
     */

 class SftAccesoAmbitoTest extends PHPUnit_Framework_TestCase {

    protected $object;
    protected $datos = array();
    protected $fecha;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
      $this->object = new SftAccesoAmbito();

      $this->fecha = date("Y-m-d H:m:s");

      $this->datos[0] =  18; // Id
      $this->datos[1] =  1; // Id_acceso
      $this->datos[2] =  1; // Id_ambito
      $this->datos[3] =  $this->fecha; // fecha_inicio
      $this->datos[4] =  $this->fecha; // fecha_fin
      $this->datos[5] =  $this->fecha; // fecha_caducidad
      $this->datos[6] = 0; // estado

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

    public function testgetIdAmbito() {

        $this->object->setIdAmbito(1);

        $this->assertEquals(1, $this->object->getIdAmbito());

    }

    /**
     * testGetIdAcceso()
     * Testing that getIdAcceso() returns the Id
     */

    public function testgetIdAcceso() {

        $this->object->setIdAcceso(1);

        $this->assertEquals(1, $this->object->getIdAcceso());

    }
    



 }



?>
