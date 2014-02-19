#Ajax

This class is intended to aid you with any ajax calls that you may make. It allows you to easily format your output from a request.

##Properties

####direct (static) = true
Default value set to true to allow direct requests, set to false to limit.

##Methods

####build (static)(data, allowCallbacks = true)
Return json given an array input. Exits if origin of request is not valid, returns with nothing if theres no outputted json, otherwise returns the json encoding of the array.

####output (static)(data, allowCallbacks)
Echo the returned json from a build() call.

####validOrigin (static)
Returns true if ```$direct``` is set to true, otherwise return whether or not it's an XMLHttpRequest.