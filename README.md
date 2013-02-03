dalia-it/dalia-inject
================================================================================
Provides a simple injection pattern for models.
Instead of using the constructor you call the static method `inject` and pass it
a associative array.

Usage
--------------------------------------------------------------------------------
###PHP 5.4

    class User{
        use daliaIT\inject\Inject;
        protected $givenName, $familyName;
        public function printName(){
            echo "$familyName, $givenName";
        }
    }
    
    User::inject([
        'givenName' => 'Martha', 
        'familyName' => 'Jones'])
        ->printName();
        
###PHP 5.3

    class User{
        #@import daliaIT\inject\Inject @#
        protected $givenName, $familyName;
        public function printName(){
            echo "$familyName, $givenName";
        }
    }
    
    User::inject(array(
        'givenName' => 'Martha', 
        'familyName' => 'Jones'))
        ->printName();
        