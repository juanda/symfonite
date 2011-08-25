<?php
    require_once 'PHPUnit/Framework.php';
    require_once dirname(__FILE__) . '/../../bootstrap/unit.php';

    /**
     * Test class for EdaAplicacionesSesionesPeer
     */

    class EdaAplicacionesSesionesPeerTest extends PHPUnit_Framework_TestCase {

    protected $object;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
      $this->object = new EdaAplicacionSesionesPeer();

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * testDoCount()
     */
    public function testDoCount() {

        $c = new Criteria();

        try
        {
           $this->assertEquals(1, $this->object->doCount($c));

        }catch (Exception $e)
           {
            throw $e;
           }

    }

    /**
     * testSave()
     */
    public function testSave() {

     try
        {

           $fecha = date("Y-m-d H:m:s");
           $object = new EdaAplicacionSesiones();

           $object->setIdAplicacion(4);
           $object->setIdUsuario(1);
           $object->setToken('1a');
           $object->setExpira($fecha);


           $this->assertEquals(1, $object->save());
           $this->assertNull($object->delete());

        }catch (Exception $e)
           {
            throw $e;
           }

    }


 }



?>
