#Documentation

IN PROGRESS

This is where you will find the documentation for Scaffold, we reccommend that you use the latest version of PHP when using this framework!

##Sections
####Complete
- <a href="#setting-up-routes">Setting up routes</a>
- <a href="#setting-up-a-controller">Setting up a controller</a>
- <a href="#setting-up-a-view">Setting up a view</a>

[a relative link](/docs/setting-up-a-controller.md)

####Incomplete
- Setting up a model
- Including a helper class
- Using core classes within your app
- Creating a helper class

###Setting up routes

First navigate to ```/config/routes.php``` you'll find the routes for your application here. Look at the below code:

```php
//  URL regex => controller/view/model to use.
$config['routes'] = array(
	//  Our error controller
	//  This not only handles 404s/403s, but also system errors.
	'error' => 'error',
	
	//  This is an example route for your index controller
	'index' => 'main'
);
```

This suggests that any visits to ```/``` or ```/index``` will be an instance of the ```main``` controller. If you wish to add a new route to a different controller, or even a specific method of the same controller just add another (key, value) pair into the array, example:

```php
//  URL regex => controller/view/model to use.
$config['routes'] = array(
	//  Our error controller
	//  This not only handles 404s/403s, but also system errors.
	'error' => 'error',
	
	//  This is an example route for your index controller
	'index' => 'main',
	'about' => 'main.about',
	'login' => 'login'
);
```

If the user was to visit ```yourappurl.com/login``` it would invoke the login controller, and if a user were to visit ```yourappurl.com/about```
it would invoke the main controller and run a method named ```about```. This allows you to control functionality and enables you to change which view you're showing. To keep everything simple just specifiying the controller name will also invoke a method ```index``` in our example which corresponds to the value set in ```/config/misc.php```

Routing in Scaffold is very customisable and will be covered later on within a "configuring your app" secton, though there are some comments which attempt to explain various things which you're able to do.


###Setting up a view

In this short section I will show you how to set up your view, this will include the dynamic and static sides of your visual output, how to set up your stylesheets and javascript files.



##Contributions
We are open for contributions on this project, any requests or suggestions are welcome. 