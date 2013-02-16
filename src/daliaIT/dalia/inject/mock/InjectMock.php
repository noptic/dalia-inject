<?php
namespace daliaIT\dalia\inject\mock;
use daliaIT\dalia\inject\IInject;

class InjectMock implements IInject{
    public
        $publicProperty,
        $publicPropertyWithDefault = "public default value";
    
    protected
        $protectedProperty,
        $protectedPropertyWithDefault = "protected default value";
        
    private
        $privateProperty,
        $privatePropertyWithDefault = "private default value";
    
    #@access public [publicProperty publicPropertyWithDefault protectedProperty protectedPropertyWithDefault privateProperty privatePropertyWithDefault]#
    
    public function getPublicProperty(){
        return $this->publicProperty;
    }
    
    public function getPublicPropertyWithDefault(){
        return $this->publicPropertyWithDefault;
    }
    
    public function getProtectedProperty(){
        return $this->protectedProperty;
    }
    
    public function getProtectedPropertyWithDefault(){
        return $this->protectedPropertyWithDefault;
    }
    
    public function getPrivateProperty(){
        return $this->privateProperty;
    }
    
    public function getPrivatePropertyWithDefault(){
        return $this->privatePropertyWithDefault;
    }
    
    #:this
    public function setPublicProperty($value){
        $this->publicProperty = $value;
        return $this;
    }
    
    #:this
    public function setPublicPropertyWithDefault($value){
        $this->publicPropertyWithDefault = $value;
        return $this;
    }
    
    #:this
    public function setProtectedProperty($value){
        $this->protectedProperty = $value;
        return $this;
    }
    
    #:this
    public function setProtectedPropertyWithDefault($value){
        $this->protectedPropertyWithDefault = $value;
        return $this;
    }
    
    #:this
    public function setPrivateProperty($value){
        $this->privateProperty = $value;
        return $this;
    }
    
    #:this
    public function setPrivatePropertyWithDefault($value){
        $this->privatePropertyWithDefault = $value;
        return $this;
    }
    #@#
    #@import daliaIT\dalia\inject\Inject#
    
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
    
    #@#
}