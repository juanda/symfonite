<?php
    require_once 'PHPUnit/Framework.php';
    require_once dirname(__FILE__) . '/../../bootstrap/unit.php';

    /**
     * Test class for EdaConfpersonalesPeerTest
     */

    class EdaConfpersonalesPeerTest extends PHPUnit_Framework_TestCase {

    protected $object;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
      $this->object = new EdaConfpersonales();

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * testSave()
     */

    public function testSave() {

     try
        {

           $object = new EdaConfpersonales();

           $object->setIdUsuario(1);
           $object->setIdAplicacion(1);
           $object->setIdPeriodo(1);
           $object->setIdPerfil(1);
           $object->setIdAmbito(null);

           $this->assertEquals(1, $object->save());
          // $this->assertNull($object->delete());

        }catch (Exception $e)
           {
            throw $e;
           }

    }


 }


?>
