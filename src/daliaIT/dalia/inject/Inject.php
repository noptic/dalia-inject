<?php
/*/ 
type:       class
subtype:    pseuo-trait
author:     Oliver Anan <oliver@ananit.de>
package:    dalia-it/dalia-inject
tags:       [injection, factory]
================================================================================
Inject
================================================================================
Required to craete class instnaces from arrays and vice versa.

Usage
--------------------------------------------------------------------------------
This is a pseudo-trait.

PHP >= 5.4 use it as an ordinary trait.

PHP < 5.4 use the "import" macro, provided by the package "dalia-it/rough"

Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\dalia\inject;
#@trait Inject#
final class Inject
#@# 
{
    private static $injectableProperties = array();
    
    public static function inject($properties = array()){
        $class = get_called_class();
        $args = func_get_args();
        array_shift($args);
        if($args){
            $reflect = new ReflectionClass($class); 
            $instance = $reflect->newInstanceArgs($args);
        } else {
            $instance = new $class();
        }            
        if($properties){
            foreach( static::getInjectablePropertyNames() as $property ){
                if( array_key_exists( $property, $properties ) ){
                    $instance->$property = $properties[$property];
                }
            }   
        }
        if( method_exists($instance, 'postInject') ){
            $instance->postInject();
        }
        return $instance;
    }
    
    public function extract(){
        $result = array();
        foreach( static::getInjectablePropertyNames() as $property ){
            $result[$property] = $this->$property;
        }
        return $result;
    }
    
    public static function getInjectablePropertyNames(){
        $class = get_called_class();
        $names = \daliaIT\dalia\inject\ReflectionCache::getInjectablePropertyNames($class);
        if($names !== null){
            return $names;
        } else {
            $names = array();
            $reflect = new \ReflectionClass($class);
            foreach ($reflect->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED) 
                as $property) 
            {
                $names[] = $property->getName();
            }
            \daliaIT\dalia\inject\ReflectionCache::setInjectablePropertyNames($class, $names);
            return $names;
        }
    }

}
?>