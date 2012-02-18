<?php

    require_once 'PHPUnit/Framework.php';
    require_once dirname(__FILE__) . '/../../bootstrap/unit.php';

    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */

    class EdaEmailsPeerTest extends PHPUnit_Framework_TestCase {

    protected $object;


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
      $this->object = new SftEmailPeer();

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
           $object3 = new SftEmail();

           $object3->setDireccion('Blas@gmail.com');
           $object3->setPredeterminado('1');
           $object3->setIdPersona('3');
           $object3->setIdOrganismo(null);

           $this->assertEquals(1, $object3->save());

           $this->assertNull($object3->delete());

        }catch (Exception $e)
           {
            throw $e;
           }

    }


 }

 /*
 $object2 = new SftEmailPeer();
 $object3 = new SftEmail();

 $object3->setDireccion('Blas@gmail.com');
 $object3->setPredeterminado('1');
 $object3->setIdPersona('3');
 $object3->setIdOrganismo(null);

 $c1 = new Criteria();

 echo "SftEmailPeer()->doCount(): ".$object2->doCount($c1)."\n";

 $email_data = array();
 $email_data['direccion']= 'Blas@gmail.com';
 $email_data['predeterminado']= '1';
 $email_data['id_persona']= '8';
 $email_data['id_organismo']= null;

 //echo "SftEmailPeer()->doInsert(): ".$object2->doInsert($email_data)."\n";

 $c2 = $c1->getNewCriterion(SftEmailPeer::DIRECCION , $email_data['direccion'], Criteria::LIKE);
 $c1 -> add($c2);
 //echo "SftEmailPeer()->doInsert(): ".$object2->doInsert($object3)."\n";
 //echo "SftEmail()->save(): ".$object3->save()."\n";
 //$object2->doUpdate($object3);
  
  */
?>
