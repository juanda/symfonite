<?php

    require_once 'PHPUnit/Framework.php';
    require_once dirname(__FILE__) . '/../../bootstrap/unit.php';

    /**
     * Test class for EdaAccesosPeer
     */

    class EdaAmbitosPeerTest extends PHPUnit_Framework_TestCase {

    protected $object;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
      $this->object = new EdaAccesoAmbitoPeer();

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
           $this->assertNotEquals(0, $this->object->doCount($c));

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

           $object = new EdaAmbitosI18n();

           $object->setId(1);
           $object->setNombre('nombre');
           $object->setDescripcion('descripcion');
           $object->setIdCultura('en_US');
       
           $this->assertEquals(1, $object->save());
           $this->assertNull($object->delete());

        }catch (Exception $e)
           {
            throw $e;
           }

    }


 }
?>
