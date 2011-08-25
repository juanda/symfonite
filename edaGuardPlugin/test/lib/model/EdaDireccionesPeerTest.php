<?php

    require_once 'PHPUnit/Framework.php';
    require_once dirname(__FILE__) . '/../../bootstrap/unit.php';



    class EdaDireccionesPeerTest extends PHPUnit_Framework_TestCase {

    protected $object;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
      $this->object = new EdaDireccionesPeer();

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * testDoCount()
     * Testing that doCount() returns the number of direcciones from the table: eda_direcciones
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
     * testDoCount()
     * Testing that doCount() returns the number of email from the table: eda_emails
     */

    public function testSave() {

        try
        {
           $object3 = new EdaDirecciones();
           $tipo_direccion = new EdaTiposdireccion();

           $object3->setEdaTiposdireccion($tipo_direccion);
           $object3->setEdaOrganismos(null);
           $object3->setEdaPersonas(null);
           $object3->setDomicilio('Cuatro caminos');
          
           $this->assertEquals(2, $object3->save()); /*devuelve 2???*/
           $this->assertNull($object3->delete());

        }catch (Exception $e)
           {
            throw $e;
           }

    }


 }


?>
