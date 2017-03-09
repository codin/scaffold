<?php 

namespace Scaffold\Database;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Handles the migration system.
 */
class Migrator
{
    /**
     * The config for this migrator.
     * 
     * @var array
     */
    private $config;

    /**
     * Pull in the database config so that
     * we know where we're looking to find
     * the migrations files.
     */
    public function __construct()
    {
        $this->config = config()->get('database');
        $this->filesystem = new Filesystem;

        $this->path = root_path() . $this->config['migrations_path'] . '/';
    }

    /**
     * Create a new migration file with a given name.
     * 
     * @param  string $name
     * @return void
     */
    public function putMigration($name)
    {
        $code = file_get_contents(root_path() . $this->config['migration_template']);
        
        $classname = explode('_', $name);
        end($classname);

        $code = str_replace('{class_name}', current($classname), $code);
        
        $fullPath = $this->path . $name . '.php';

        $this->filesystem->dumpFile($fullPath, $code);
    }
}