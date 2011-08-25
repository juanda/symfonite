<?php
    require_once 'PHPUnit/Framework.php';
    require_once dirname(__FILE__) . '/../../bootstrap/unit.php';

   /**
    * Test class for EdaAmbitos
    */

 class EdaAmbitosII18nTest extends PHPUnit_Framework_TestCase {

    protected $object;
    protected $datos = array();

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
      $this->object = new EdaAmbitos();

      $this->datos[0] =  18; // Id
      $this->datos[1] =  'nombre'; // nombre
      $this->datos[2] =  'descripcion'; // descripcion
      $this->datos[3] =  'en_US'; // id_cultura {en_US | en_GB | ..}

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
