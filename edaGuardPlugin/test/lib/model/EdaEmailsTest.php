<?php
    require_once 'PHPUnit/Framework.php';
    require_once dirname(__FILE__) . '/../../bootstrap/unit.php';

/**
 * Test class for EdaEmails
 */

 class EdaEmailsTest extends PHPUnit_Framework_TestCase {

    protected $object;
 

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
      $this->object = new EdaEmails();

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * testGetIdEmail()
     * Testing that getIdMail() returns the Id
     */
    public function testHasOnlyDefaultValues(){

        $this->assertTrue($this->object->hasOnlyDefaultValues());

    }

    /**
     * testGetIdEmail()
     * Testing that getIdMail() returns the Id
     */

    public function testGetIdEmail() {

        $this->assertEquals($this->object->getId(), $this->object->getIdEmail());

    }

    /**
     * testGetEdaUsuario
     * Testing that ..
     * @todo: fix the error message: non object
     */
    /*
    public function testGetEdaUsuario() {

        $object = new EdaEmails();

        //$this->assertNotNull($object->getEdaUsuario());
        
        if (is_null($object-> getIdPersona()))
        {
            $this->assertNotNull($object->getEdaOrganismos()->getEdaUsuarioss());
        }else{
              $this->assertNotNull($object->getEdaPersonas()->getEdaUsuarioss());
        }

    }
      */

    /**
     * testGuardUserSettersAndGetters()
     * Testing the setters and the getters of the class
     */
    public function testSettersAndGetters() {

        $id_aux = $this->object->getId();
        $dir_aux = $this->object->getDireccion();
        $predeterminado_aux = $this->object->getPredeterminado();
        $idPersona_aux = $this->object->getIdPersona();
        $idOrganismo_aux = $this->object->getIdOrganismo();

        $this->object->setId(127);
        $this->object->setDireccion('coco@gmail.com');
        $this->object->setPredeterminado('1');
        $this->object->setIdPersona('3');
        $this->object->setIdOrganismo(null);

        $this->assertEquals(127, $this->object->getId());
        $this->assertEquals('coco@gmail.com', $this->object->getDireccion());
        $this->assertEquals('1', $this->object->getPredeterminado());
        $this->assertEquals('3', $this->object->getIdPersona());
        $this->assertNUll($this->object->getIdOrganismo());

     }


     /**
     * testSave()
     * Testing the save() method of the class
     */

    public function testSave() {
        try
        {
           $this->assertEquals(1, $this->object->save());
           $this->assertNull($this->object->delete());

        }catch (Exception $e)
           {
            throw $e;
           }

    }
 }
/*
$object2 = new EdaEmails();
$object2->hasOnlyDefaultValues();
echo "EdaEmails()->getIdPersona(): ".$object2->getIdPersona()."\n";
echo "EdaEmails()->getEdaUsuario(): ".$object2->getEdaUsuario()."\n";
*/
?>
