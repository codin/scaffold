#Ajax

This class is intended to aid you with any ajax calls that you may make. It allows you to easily format your output from a request.

##Properties

```static direct = true```
<br>
Default value set to true to allow direct requests, set to false to limit.

##Methods

```static build(data, allowCallbacks = true)``` 
<br>
Return json given an array input. Exits if origin of request is not valid, returns with nothing if theres no outputted json, otherwise returns the json encoding of the array.

```static output(data, allowCallbacks)```
<br>
Echo the returned json from a build() call.

```static validOrigin()```
<br>
Returns true if ```$direct``` is set to true, otherwise return whether or not it's an XMLHttpRequest.
