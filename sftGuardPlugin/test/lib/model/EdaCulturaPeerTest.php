<?php

    require_once 'PHPUnit/Framework.php';
    require_once dirname(__FILE__) . '/../../bootstrap/unit.php';
   

    class EdaCulturaPeerTest extends PHPUnit_Framework_TestCase {

    protected $object;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
      $this->object = new SftCulturaPeer();

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * testDoCount()
     * Testing that doCount() returns the number of email from the table: eda_emails
     */

    public function testDoCount() {

        $c = new Criteria();

        try
        {
           $this->assertEquals(2, $this->object->doCount($c));
        }catch (Exception $e)
           {
            throw $e;
           }

    }

    /**
     * testDoCount()
     * Testing that doCount() returns the number of culturas from the table: eda_culturas
     */

    public function testSave() {

     try
        {
           $object3 = new SftCulturas();

           $object3->setNombre('en_US');
           $object3->setDescripcion('USA');


           $this->assertEquals(1, $object3->save());

           $this->assertNull($object3->delete());

        }catch (Exception $e)
           {
            throw $e;
           }

    }


 }

?>

