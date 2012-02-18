<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../bootstrap/unit.php';

/**
 * Test class for SftAccesoPeer
 */
class SftAccesoAmbitoPeerTest extends PHPUnit_Framework_TestCase {

    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new SftAccesoAmbitoPeer();
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

        try {
            $this->assertEquals(12, $this->object->doCount($c));
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * testSave()
     */
    public function testSave() {

        try {

            $object = new SftAccesoAmbito();
            $fecha = date("Y-m-d H:m:s");

            $object->setIdAcceso(1);
            $object->setIdAmbito(1);
            $object->setFechainicio($fecha);
            $object->setFechafin($fecha);
            $object->setFechacaducidad($fecha);
            $object->setEstado(0);

            $this->assertEquals(1, $object->save());
            $this->assertNull($object->delete());
        } catch (Exception $e) {
            throw $e;
        }
    }

}

?>
