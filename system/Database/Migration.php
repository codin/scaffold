<?php 

namespace Scaffold\Database;

/**
 * This class should be extended for any 
 * database migrations.
 */
abstract class Migration
{
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