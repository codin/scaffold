#Setting up helpers

Helpers within Scaffold are an easy way to plug in your own libraries/classes to help with the development of your application. They allow you to add extra functionality on a per-controller basis, yet reducing code duplication. For instance, if you wish to use a certain API it is possible to add that functionality into the controller which requires it, though what if another controller requires that functionality too? You'd have to duplicate the code. 

We suggest housing the class that interfaces the API within the helper folder. This section will show you how you can include exisiting helper files, and the simple steps you must take to make your own. (It's dead simple)

###Including

Navigate to your controller, in this example I'll be using the provided ```main``` controller. Within the constructor add the folling line:

```php
$this->helper->load('test');
```

The above line loads in and instantiates a helper named test, this can be found in the following file ```app/helpers/test.php```. Whenever the ```load()``` method is called it will grab the helpers from ```app/helpers/``` unless an optional ```URL``` parameter is supplied to the ```load()``` method.

```php
$this->helper->load('test', 'my/custom/helper/dir');
```

Of course we don't want you having to recall the same method over and over for more than one helper! So we made it possible to load multiple just by using an array:

```php
$this->helper->load(array('test', 'example', 'another example'));
```

###Using a helper and creating your own

Okay, now that we've managed to include all of the helpers we want, we can start to put them to use! The test helper comes with a constructor, a static method and a standard public method.

We found it most useful to make our helpers static as this is clean and in most cases the helper classes will not be required to keep track of instance based information, that is more oriented around the controller, though we've still made it possible to use the latter.

The test helper has two methods, ```hello()``` and ```world()```, these both dump strings onto the view so that you're able to see it in action. ```hello()``` is static, within your controller you're able to call it like so:

```php
Test::hello();
```

If you load your app you should see an output on the screen like so:

```
array (size=1)
  0 => string 'constructing the test helper' (length=28)
array (size=1)
  0 => string 'hello' (length=5)
```

The first comes from the constructor, you're able to remove the constructor if you do not require it. And the second is produced by the static call to ```hello()``` we just made.

So how do we call non-static methods? Well we have to take a route through the helper class to do so:

```php
$this->helper->test->world();
```

The helper object is stored in ```$this->helper->{helper_name}```, then we just call ```world()``` You should now see an output like so:

```
array (size=1)
  0 => string 'constructing the test helper' (length=28)
array (size=1)
  0 => string 'hello' (length=5)
array (size=1)
  0 => string 'world' (length=5)
```

And that's it, using a helper class is simple once you know how! And you know what's even simpler? Creating your own! A helper is just a class and does not require any fancy things in order for it to run, we just advise that they're located in ```app/helpers``` when possible.

[Go home](../README.md) ---
[Previous](setting-up-a-view.md) ---
[Next](setting-up-a-model.md)