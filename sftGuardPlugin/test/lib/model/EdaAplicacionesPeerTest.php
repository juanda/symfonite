<?php
    require_once 'PHPUnit/Framework.php';
    require_once dirname(__FILE__) . '/../../bootstrap/unit.php';

    /**
     * Test class for SftAplicacionPeer
     */

    class SftAplicacionPeerTest extends PHPUnit_Framework_TestCase {

    protected $object;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
   protected function setUp() {
      $this->object = new SftAplicacionPeer();

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
           $this->assertEquals(4, $this->object->doCount($c));

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

           $object = new SftAplicacion();
           $fecha = date("Y-m-d H:m:s");

           $object->setCodigo('Codigo Aplicacion');
           $object->setNombre('Nombre Aplicacion');
           $object->setDescripcion('Descripcion');
           $object->setLogotipo(null);
           $object->setUrlSvn('');
           $object->setClave('4a');
           $object->setIdCredencial(1);
           $object->setCreatedAt($fecha);
           $object->setUpdatedAt($fecha);
           $object->setSfApp('backend');
           $object->setTextoIntro('<p>texto intro</p>');

           $this->assertEquals(1, $object->save());
           $this->assertNull($object->delete());

        }catch (Exception $e)
           {
            throw $e;
           }

    }


 }


?>
