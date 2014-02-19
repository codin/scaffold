#Setting up a model

In this section we will be covering models within your application, a simple way to add a interface to a database or place of storage. This section is a little more complicated and requires a bit more set up. The examples given will require you to set up a simple database or use an existing one following the schema which will be mentioned shortly.

Again the ```main``` controller will be used as an example as a ```main``` model already exists in ```app/models```, upon opening the file the contents should be like so:

```php
class Main_model extends Model {
	public function __construct() {
		parent::__construct();
	}
}
```

Any model must be suffixed with ```_model``` to denote that it is different from the controller and must extend ```Model```, within the constructor it must also call it's parents constructor. The only functionality that this model currently provides is setting up a connection to the database, the configuration for the database connection can be found in ```config/database.php```. You should modify them to for your database.

In this guide it does not matter what the name of your database is just so long as you add a table named test, with two fields: id and name. Here is some SQL that you should run to ensure that your table is the same as the one used in this example.

```SQL
CREATE TABLE testtable (
	id INT(4) AUTO_INCREMENT,
	name VARCHAR(60),
	PRIMARY KEY(id)    
)
```

Once you have done this we can begin working on the model. Create two methods inside your model, ```add``` and ```get```.

```php
public function add() {
	
}

public function get() {
	
}
```

Were going to use these to interact with the database and the table which we just created. For now place an echo statement inside each of the methods. e.g ```echo "get method called";```

We can then navigate back to our controller, this is where we will be using the model. Within the controller the model object is stored in ```$this->model```. Now call both of the methods that we have just created:

```php
$this->model->add();
$this->model->get();
```

The next step is to tie this all into the database, to do so we need to use the connection to the database which is available using ```$this->db```, in this guide we're only going to be using ```insert``` and ```select``` statements, full documentation on the database class can be found [here](../classes/database.md).

The following line will insert a new record into our table, add this to the ```add``` method.

```php
$this->db->insert()->into('testtable')->values(array('null', 'Your_Name'))->go();
```

Refresh your app, check your database to see if it has infact inserted a new record. If it was successful we can now move onto the ```get``` method.

Inside the ```get``` block place the following code. This should select all records in the table and dump them out for you to see.

```php
$results = $this->db->select('*')->from('testtable')->fetch();
dump($results);
```

Now you should be able to extend your model to provide more functionality, though I suggest you have a good read through the documentation of the ```database``` class before you attempt to build any complex applications. 

[Go home](../README.md) ---
[Previous](setting-up-helpers.md)