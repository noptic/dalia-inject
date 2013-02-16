<?php
namespace daliaIT\dalia\inject;
require __DIR__.'/../autoload.php';
class ReflectionCacheTest extends    \PHPUnit_Framework_TestCase
{
    public function test_cache(){
        $data = array('one','librum','dr');
        ReflectionCache::setInjectablePropertyNames(__CLASS__,$data);
        $this->assertEquals($data,ReflectionCache::getInjectablePropertyNames(__CLASS__));
    }
}