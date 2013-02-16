<?php
namespace daliaIT\dalia\inject;
use daliaIT\dalia\inject\mock\InjectMock;
require __DIR__.'/../autoload.php';
class InjectTest extends \PHPUnit_Framework_TestCase
{
    public function setUp(){
        ReflectionCache::flush();
    }
    
    public function tearDown(){
        ReflectionCache::flush();
    }
    
    public function test_getInjectablePropertyNames(){
        $this->assertEquals(InjectMock::getInjectablePropertyNames(),array(
            'publicProperty',
            'publicPropertyWithDefault',
            'protectedProperty',
            'protectedPropertyWithDefault'     
        ));
    }
    
    /**
     * @depends test_getInjectablePropertyNames
     */
    public function test_inject_returns_correct_class(){
        $result = InjectMock::inject();
         $this->assertTrue(is_object($result),'No object returned');  
        $this->assertTrue($result instanceof InjectMock, 'Wrong class returned');      
    }
    
    /**
     * @depends test_inject_returns_correct_class
     */
    public function test_inject_keeps_defaults(){
        $result = InjectMock::inject( array() );
        $this->assertEquals( 'public default value',      $result->getPublicPropertyWithDefault()     );
        $this->assertEquals( 'protected default value',   $result->getProtectedPropertyWithDefault()  );
        $this->assertEquals( 'private default value',    $result->getPrivatePropertyWithDefault()    );
    }
    
    /**
     * @depends test_inject_returns_correct_class
     */
    public function test_inject_sets_protecties(){
        $result = InjectMock::inject( array(
            'publicProperty'    => true,
            'protectedProperty' => true
        ));
        $this->assertTrue( $result->getPublicProperty(),    'public property was not set'   );
        $this->assertTrue( $result->getProtectedProperty(), 'protected property was not set');      
    }
    
    /**
     * @depends test_inject_sets_protecties
     */
    public function test_inject_does_not_set_privat_property(){
        $result = InjectMock::inject( array('privateProperty' => true) );
        $this->assertEquals( null, $result->getPrivateProperty() );    
    }
    
    public function test_extract_gets_properties(){
        $result = InjectMock::inject();
        $this->assertEquals($result->extract(),array(
            'publicProperty'                => null,
            'publicPropertyWithDefault'     => 'public default value',
            'protectedProperty'             => null,
            'protectedPropertyWithDefault'  => 'protected default value',
        ));
    }
    
    public function test_unkown_properties_are_not_injected(){
        $result = InjectMock::inject(array('foo' => 'bar'));
        $this->assertEquals($result->extract(),array(
            'publicProperty'                => null,
            'publicPropertyWithDefault'     => 'public default value',
            'protectedProperty'             => null,
            'protectedPropertyWithDefault'  => 'protected default value',
        ));
    }

}