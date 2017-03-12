<?php 

namespace Scaffold\Database;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

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
     * The name of the table we use to
     * keep track of the migrations.
     * 
     * @var string
     */
    private $tableName;

    /**
     * Pull in the database config so that
     * we know where we're looking to find
     * the migrations files.
     */
    public function __construct()
    {
        $this->config = config()->get('database');
        $this->filesystem = new Filesystem;
        $this->finder = new Finder;

        $this->path = root_path() . $this->config['migrations_path'] . '/';

        $this->tableName = $this->config['migrations_table'];
    }

    /**
     * Create a new migration file with a given name.
     * 
     * @param  string $name
     * @return void
     */
    public function putMigration($name)
    {
        $code = file_get_contents(root_path() . $this->config['migrations_template']);
        $code = str_replace('{class_name}', $this->extractClassname($name), $code);
        
        $fullPath = $this->path . $name . '.php';

        $this->filesystem->dumpFile($fullPath, $code);
    }

    /**
     * Get all of the migrations.
     * 
     * @return array<Migration>
     */
    public function getAllMigrations()
    {
        $this->finder->files()
            ->in($this->path)
            ->name('*.php')
            ->contains('extends Migration')
            ->sortByName();

        $migrations = [];

        foreach ($this->finder as $file) {
            include_once($file->getRealPath());

            $classname = str_replace('.php', '', $file->getFilename());

            $parts = explode('_', $classname);

            end($parts);

            $classname = current($parts);
            
            if (!class_exists($classname)) {
                throw new \Exception('Migration ' . $file->getFilename() . ' has an invalid classname.');
            }

            $instance = new $classname;
            $migrations[$file->getFilename()] = $instance;
        }

        return $migrations;
    }

    /**
     * Does a row for a specified migration already exist?
     * 
     * @param  string $migration
     * @return boolean
     */
    public function checkDatabaseForMigration($migration)
    {
        if (!database()->schema()->hasTable($this->tableName)) {
            return false;
        }

        return database()->table($this->tableName)
            ->where('migration', $migration)
            ->exists();
    }

    /**
     * Add a new migration to the database.
     * 
     * @param  string $migration
     * @return void
     */
    public function addMigrationToDatabase($migration)
    {
        return database()->table($this->tableName)->insert([
            'migration' => $migration,
        ]);
    }

    /**
     * Remove a migration from the database.
     *
     * @param  string $migration
     * @return void
     */
    public function removeMigrationFromDatabase($migration)
    {
        return database()->table($this->tableName)
            ->where('migration', $migration)
            ->delete();
    }

    /**
     * Extract the classname from the name
     * of the file.
     * 
     * @param  string $name
     * @return string
     */
    private function extractClassname($name)
    {
        $classname = explode('_', $name);
        end($classname);
        return current($classname);
    }
}
