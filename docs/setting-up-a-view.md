#Setting up a view

In this short section I will show you how to set up a simple view, this will include the dynamic and static sides of your visual output, how to set up your stylesheets and javascript files.

The example view file ```main.php``` was covered in the section on setting up your controller, we're going to look deeper into how this ties into the application and extra view files that are used to build the entire front end of your application.

The first stage in setting up your view is understanding how our templating system works, navigate to ```html/tenplate.html``` here you should find something similar to this:

```html
<!doctype html>
<html lang="{{language/en-gb}}">
	<head>
		<meta charset="utf-8">
		<title>{{title/Welcome to Scaffold!}}</title>
		
		<link rel="stylesheet" href="{{base}}assets/css/style.css">
	</head>
	<body class="{{class/site}}">
		<h1>{{heading/This is a test heading}}</h1>
		
		{{view}}
		
		[base]
			~header~
		[/base]
	</body>
</html>
```

This defines how the page will be layed out, it includes your basis stylesheet, and pulls in the content from your view. We've added some neat features enabling you to dynamically swap out values, ```{{something_here}}``` represents a value that you're pulling in, similar to previously shown in the setting up of a controller.

Our templating system automatically sets up the ```base``` value as well as a few others not used in this example file, ```scaffold_version``` and ```load_time``` to include them into our template view we would simply add the following to an appropriate place in our file:

```html
{{load_time}}

// OR

{{scaffold_version}}
```

There are a few which are required for the templating class to work correctly these are:
- ```class```
- ```view``` 

It's really easy to add your own, for example if we place ```{{test}}``` underneath ```{{view}}```, then navigate back to ```app/controllers/main.php``` and ensure the constructor looks like this:

```php
public function __construct() {
		parent::__construct();

		//  Set template data
		$this->template->set(array(
			'heading' => 'test',
			'hello' => 'world',

			'test' => 'Passing test data to the default template structure'
		));
	}
```

We should see the test text appear at the bottom of our view. Neat huh? Note that this templating langauge is only available within this templating file and not in the views themselves. As it is intended to provide a placholder for real content and the view is the content. 

We've also added the feature of fallbacks if something were to go wrong or you forget to set a value in the controller, this can be added like such as is used within the example template class.

```html
{{variable/fallback_string}}
```

You are also able to conditionally include data, ```[base].....[/base]``` is an example of this. It checks whether the value of base in the template settings evaluates to true, by either being a boolean value or containing non-null data. If it is true it will then allow the content between the tags to be displayed, in this example it is a conditional surrounding the inclusion of a partial view, which leads us onto our next topic.... though lets look how we can use conditionals ourselves.

Go back to the ```main``` controller and add the following setting: ```'show_hello' => true```, then modify the ```template.html``` file to read:

```html
<!doctype html>
<html lang="{{language/en-gb}}">
	<head>
		<meta charset="utf-8">
		<title>{{title/Welcome to Scaffold!}}</title>
		
		<link rel="stylesheet" href="{{base}}assets/css/style.css">
	</head>
	<body class="{{class/site}}">
		<h1>{{heading/This is a test heading}}</h1>
		
		[show_hello]
			<p>Hello this is a conditional test</p>
		[/show_hello]

		{{view}}
		
		[base]
			~header~
		[/base]
	</body>
</html>
```

This is a neat way to dynamically alter the template structure you use! As by purely leaving that option out in another controller will not display our text.

Note you can also invert conditionals by using the not operator e.g. ```[!show_hello]...[/show_hello]```

Now to move onto partials, these can be included using ```~the_name_of_the_partial~```, these are located in ```app/partials/``` and represent static sections of your view such as a footer or header. They're not required but can be handy.

That's pretty much all you need to know about views, we have tried to make them as easy for non-programmers to use as possible so that teams are able to work on the same project with different levels of knowledge. Though one last thing... css files, js and images should be found in ```html/assets/```

[Go home](../README.md) ---
[Previous](setting-up-a-controller.md) ---
[Next](setting-up-helpers.md)
