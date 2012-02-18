<?php

    require_once 'PHPUnit/Framework.php';
    require_once dirname(__FILE__) . '/../../bootstrap/unit.php';

    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */

    class SftAmbitoTiposTest extends PHPUnit_Framework_TestCase {

    protected $object;
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
      $this->object = new SftAmbitoTipos();
    

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }
  
    /**
     * testToString().
     */
    public function testToString() {

     $nombre  = $this->object->getNombre();

     $this->assertEquals($nombre, $this->object->__toString());

    }


    /**
     * testValues().
     */
    public function testValues() {

     $c = new Criteria();

     $peer = new SftAmbitoTiposPeer();

     $valor1 =  $peer->retrieveByPK(1);
     $valor2 =  $peer->retrieveByPK(2);
     $valor3 =  $peer->retrieveByPK(3);
 
     $this->assertEquals('cursos', $valor1->getNombre());
     $this->assertEquals('proyectos', $valor2->getNombre());
     $this->assertEquals('areas', $valor3->getNombre());
     $this->assertEquals(3, $peer->doCount($c));
    }

 }



?>
