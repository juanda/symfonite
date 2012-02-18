<?php
    require_once 'PHPUnit/Framework.php';
    require_once dirname(__FILE__) . '/../../bootstrap/unit.php';


    class SftAplicacionSesionesTest extends PHPUnit_Framework_TestCase {

    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
      $this->object = new SftAplicacionSesion();


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


 }



?>
