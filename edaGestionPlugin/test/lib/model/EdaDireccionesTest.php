<?php
    require_once 'PHPUnit/Framework.php';
    require_once dirname(__FILE__) . '/../../bootstrap/unit.php';

/**
 * Test class for EdaDirecciones
 */

 class EdaDireccionesTest extends PHPUnit_Framework_TestCase {

    protected $object;
    protected $datos = array();
    protected $tipo_direccion;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
      $this->object = new EdaDirecciones();
      $this->tipo_direccion = new EdaTiposdireccion();
     
      $this->datos[0] =  777; //id direccion
      $this->datos[1] = 1; //id tipo direccion
      $this->datos[2] = 'tipo_via'; //tipo_via
      $this->datos[3] = 'domicilio'; //domicilio
      $this->datos[4] = 'numero'; // numero
      $this->datos[5] = 'escalera'; // escalera
      $this->datos[6] = 'piso'; // piso
      $this->datos[7] = 'letra'; // letra
      $this->datos[8] = 'municipio'; // municipio
      $this->datos[9] = 'provincia'; // num_login_fails
      $this->datos[10] = 'pais'; // pais
      $this->datos[11] = 'codigo postal'; //cp
      $this->datos[12] = null; //IdPersona
      $this->datos[13] = null; //IdOrganismo

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
     * testGetIdDireccion()
     * Testing that getIdDireccion() returns the Id
     */

    public function testGetIdDireccion() {

        $this->assertEquals($this->object->getId(), $this->object->getIdDireccion());

    }

    /**
     * testSettersAndGetters()
     * Testing the setters and the getters of the class
     */
    public function testSettersAndGetters() {

        $this->object->setId($this->datos[0]);
        $this->object->setEdaTiposdireccion($this->tipo_direccion);
        $this->object->setTipovia($this->datos[2]);
        $this->object->setDomicilio($this->datos[3]);
        $this->object->setNumero($this->datos[4]);
        $this->object->setEscalera($this->datos[5]);
        $this->object->setPiso($this->datos[6]);
        $this->object->setLetra($this->datos[7]);
        $this->object->setMunicipio($this->datos[8]);
        $this->object->setProvincia($this->datos[9]);
        $this->object->setPais($this->datos[10]);
        $this->object->setCp($this->datos[11]);
        $this->object->setIdPersona($this->datos[12]);
        $this->object->setIdOrganismo($this->datos[13]);

        $this->assertEquals($this->datos[0], $this->object->getId());
        $this->assertType('integer',$this->object->getId());
        //$this->assertEquals($this->tipo_direccion, $this->object->getIdTipodireccion());
        $this->assertEquals($this->datos[2], $this->object->getTipovia());
        $this->assertType('string',$this->object->getTipovia());
        $this->assertEquals($this->datos[3], $this->object->getDomicilio());
        $this->assertType('string',$this->object->getDomicilio());
        $this->assertEquals($this->datos[4], $this->object->getNumero());
        $this->assertType('string',$this->object->getNumero());
        $this->assertEquals($this->datos[5], $this->object->getEscalera());
        $this->assertType('string',$this->object->getEscalera());
        $this->assertEquals($this->datos[6], $this->object->getPiso());
        $this->assertType('string',$this->object->getPiso());
        $this->assertEquals($this->datos[7], $this->object->getLetra());
        $this->assertType('string',$this->object->getLetra());
        $this->assertEquals($this->datos[8], $this->object->getMunicipio());
        $this->assertType('string',$this->object->getMunicipio());
        $this->assertEquals($this->datos[9], $this->object->getProvincia());
        $this->assertType('string',$this->object->getProvincia());
        $this->assertEquals($this->datos[10], $this->object->getPais());
        $this->assertType('string',$this->object->getPais());
        $this->assertEquals($this->datos[11], $this->object->getCp());
        $this->assertType('string',$this->object->getCp());
        $this->assertEquals($this->datos[12], $this->object->getIdPersona());
        $this->assertNull($this->object->getIdPersona());
        $this->assertNull($this->object->getIdOrganismo());
 }

    /**
     * testHydrate()
     * Testing the hydrate method of the class
     */
    public function testHydrate() {

        $object = new EdaDirecciones();

        try
        {
            $object->hydrate($this->datos);
    
            $this->assertEquals($this->datos[0], $object->getId());
            $this->assertType('integer',$object->getId());
           // $this->assertEquals($this->datos[1], $object->getIdTipodireccion());
            $this->assertEquals($this->datos[2], $object->getTipovia());
            $this->assertType('string',$object->getTipovia());
            $this->assertEquals($this->datos[3], $object->getDomicilio());
            $this->assertType('string',$object->getDomicilio());
            $this->assertEquals($this->datos[4], $object->getNumero());
            $this->assertType('string',$object->getNumero());
            $this->assertEquals($this->datos[5], $object->getEscalera());
            $this->assertType('string',$object->getEscalera());
            $this->assertEquals($this->datos[6], $object->getPiso());
            $this->assertType('string',$object->getPiso());
            $this->assertEquals($this->datos[7], $object->getLetra());
            $this->assertType('string',$object->getLetra());
            $this->assertEquals($this->datos[8], $object->getMunicipio());
            $this->assertType('string',$object->getMunicipio());
            $this->assertEquals($this->datos[9], $object->getProvincia());
            $this->assertType('string',$object->getProvincia());
            $this->assertEquals($this->datos[10], $object->getPais());
            $this->assertType('string',$object->getPais());
            $this->assertEquals($this->datos[11], $object->getCp());
            $this->assertType('string',$object->getCp());
            $this->assertEquals($this->datos[12], $object->getIdPersona());
            $this->assertNull($object->getIdPersona());
            $this->assertNull($object->getIdOrganismo());
        
        }catch (Exception $e)
           {

            throw $e;
           }

     }

    /**
     * testFromArray()
     * Testing the fromArray method of the class
     * @todo fix the password issue
     */
    public function testFromArray() {

        $object = new EdaDirecciones();
      
        try
        {
            $object->fromArray($this->datos,BasePeer::TYPE_NUM);

            $this->assertEquals($this->datos[0], $object->getId());
            $this->assertType('integer',$object->getId());
            $this->assertEquals($this->datos[1], $object->getIdTipodireccion());
            $this->assertEquals($this->datos[2], $object->getTipovia());
            $this->assertType('string',$object->getTipovia());
            $this->assertEquals($this->datos[3], $object->getDomicilio());
            $this->assertType('string',$object->getDomicilio());
            $this->assertEquals($this->datos[4], $object->getNumero());
            $this->assertType('string',$object->getNumero());
            $this->assertEquals($this->datos[5], $object->getEscalera());
            $this->assertType('string',$object->getEscalera());
            $this->assertEquals($this->datos[6], $object->getPiso());
            $this->assertType('string',$object->getPiso());
            $this->assertEquals($this->datos[7], $object->getLetra());
            $this->assertType('string',$object->getLetra());
            $this->assertEquals($this->datos[8], $object->getMunicipio());
            $this->assertType('string',$object->getMunicipio());
            $this->assertEquals($this->datos[9], $object->getProvincia());
            $this->assertType('string',$object->getProvincia());
            $this->assertEquals($this->datos[10], $object->getPais());
            $this->assertType('string',$object->getPais());
            $this->assertEquals($this->datos[11], $object->getCp());
            $this->assertType('string',$object->getCp());
            $this->assertEquals($this->datos[12], $object->getIdPersona());
            $this->assertNull($object->getIdPersona());
            $this->assertNull($object->getIdOrganismo());
                      
        }catch (Exception $e)
           {
              throw $e;
           }

     }

     /**
     * testCopy()
     * Testing the copy method of the class
     * this method does not copy the Id
     */
     /*
    public function testCopy() {

        $object = new EdaDirecciones();

        try
        {

           $object->copy($this->object);

           $this->assertNull($object->getId()); //this method does not copy the Id
           //$this->assertType('integer',$object->getId());
           $this->assertNull($object->getIdTipodireccion());
           $this->assertEquals($this->datos[2], $object->getTipovia());
           $this->assertType('string',$object->getTipovia());
           $this->assertEquals($this->datos[3], $object->getDomicilio());
           $this->assertType('string',$object->getDomicilio());
           $this->assertEquals($this->datos[4], $object->getNumero());
           $this->assertType('string',$object->getNumero());
           $this->assertEquals($this->datos[5], $object->getEscalera());
           $this->assertType('string',$object->getEscalera());
           $this->assertEquals($this->datos[6], $object->getPiso());
           $this->assertType('string',$object->getPiso());
           $this->assertEquals($this->datos[7], $object->getLetra());
           $this->assertType('string',$object->getLetra());
           $this->assertEquals($this->datos[8], $object->getMunicipio());
           $this->assertType('string',$object->getMunicipio());
           $this->assertEquals($this->datos[9], $object->getProvincia());
           $this->assertType('string',$object->getProvincia());
           $this->assertEquals($this->datos[10], $object->getPais());
           $this->assertType('string',$object->getPais());
           $this->assertEquals($this->datos[11], $object->getCp());
           $this->assertType('string',$object->getCp());
           $this->assertEquals($this->datos[12], $object->getIdPersona());
           $this->assertType('integer',$object->getIdPersona());
           $this->assertEquals($this->datos[13], $object->getIdOrganismo());
           $this->assertType('integer',$object->getId());
           

        }catch (Exception $e)
           {
            throw $e;
           }
     }
*/
     /**
     * testSave()
     * Testing the save() method of the class
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

         $object3->setTipovia($this->datos[2]);
         $object3->setDomicilio($this->datos[3]);
         $object3->setNumero($this->datos[4]);
         $object3->setEscalera($this->datos[5]);
         $object3->setPiso($this->datos[6]);
         $object3->setLetra($this->datos[7]);
         $object3->setMunicipio($this->datos[8]);
         $object3->setProvincia($this->datos[9]);
         $object3->setPais($this->datos[10]);
         $object3->setCp($this->datos[11]);

         $this->assertEquals(2, $object3->save()); /*devuelve 2???*/
         $this->assertNull($object3->delete());

        }catch (Exception $e)
           {
            throw $e;
           }

    }


 }

?>