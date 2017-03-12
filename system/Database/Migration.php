<?php 

namespace Scaffold\Database;

/**
 * This class should be extended for any 
 * database migrations.
 */
abstract class Migration
{

    /**
     * The schema builder.
     * 
     * @var \Illuminate\Database\Schema\Builder
     */
    protected $schema;

    /**
     * Grab the schema builder and attach it to
     * the migration instance.
     */
    public function __construct()
    {
        $this->schema =  database()->schema();
    }

    /**
     * Will be called when running a 
     * migration.
     * 
     * @return void
     */
    public abstract function up();

    /**
     * Will be called when rolling 
     * back a migration.
     * 
     * @return void
     */
    public abstract function down();
}