<?php
/*/
ReflectionCache
================================================================================
A global static cache for injection.
The data is stored in a global cache because class definitions are always global

This cache is used by the Inject trait but other classes might use a custom
logic.

To get reliable information which properties are injectable use 

    $classname::getInjectableProperties()
    
Source
--------------------------------------------------------------------------------
/*/
namespace daliaIT\dalia\inject;
abstract class ReflectionCache
{
    private static $injectablePropertyNames = array();
    
    public static function getInjectablePropertyNames($className){
        if( isset(static::$injectablePropertyNames[$className]) ){
            return static::$injectablePropertyNames[$className];
        }  else {
            return null;
        }
    }
    
    public static function setInjectablePropertyNames($className, array $names){
        static::$injectablePropertyNames[$className] = $names;
    }
    
    public static function flush(){
        static::$injectablePropertyNames = array();
    }
}
