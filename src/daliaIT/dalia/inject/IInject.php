<?php
namespace daliaIT\co3;
/*/ 
type:       interface
author:     Oliver Anan <oliver@ananit.de>
package:    dalia-it/dalia-inject
tags:       [injection, factory]
================================================================================
IInject
================================================================================
Required to craete class instnaces from arrays and vice versa.

Usage
--------------------------------------------------------------------------------
This interface is intended to be used for models. 
Data retived vie JSON or database querries can be turned into  objects without 
creating constructors for each model.
The integrity of the data must be ensured by the calling code 
 
All properties which are only used internaly (e.g. buffers amd file handles) 
should be private.

Using injectaion allows setting protected object properties when the object is 
created.

Methods
--------------------------------------------------------------------------------

### public static object inject(array $properties)
    
Creates a new  instance and injects the properties from an array.    
The properies names are used as array keys
Any additional parameters are passed to the class constructor.
#### Implemantation
 - Implementing classes should *not* allow injecting *unknown properties*
 - *Private* properties should *not* be injected
 - * Always* return an instance of the *class* which was *called*.
 - additional arguments should be passed to the class constructor
 
#### Parameters
 - `array $properties` Associative array containig the desired properties.
 - mixed $arg_1 ... $arg_n Arguments for the class constructor.
 
#### Returns
`IInject` instance of the called class


### public static array **extract()** ###
Returns an objects properties as array.
The properies names are used as array keys.

#### Implementation
 - should not return private properties
 - must not return properties which are not defined for this objects class
 
#### Returns
`array` An associative array containing the objects properties
 
Source
--------------------------------------------------------------------------------
/*/
interface IInject
{    
    #:this
    static function inject($properties);
    
    #:array
    function extract();

}
?>