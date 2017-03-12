<?php 

namespace Scaffold\Database\Command\Migration;

use Scaffold\Console\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * The command to run a migration
 */
class Migrate extends Command
{
    protected $name = 'migrate:run';

    protected $description = 'Run migrations to update the database to the latest.';

    protected $help = 'Running this command will run all migrations which are yet to be run.';

    /**
     * Handle execution of this command.
     * 
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get all migrations which haven't
        // been run yet.
        // Pull in the classes
        // Run the `up()` method on them.
        // 
        // php scaffold migrate:run
        
        $table = new Table($output);
        
        $rows = [];
        $headers = ['Migration', 'Status', 'Error'];

        $migrations = container()->get('migrator')->getAllMigrations();

        foreach ($migrations as $filename => $migration) {
            $error = '';

            try {
                $migration->up();
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }

            $rows[] = [
                $filename, 
                empty($error) ? 'Success' : 'Failed',
                $error,
            ];
        }

        $table->setHeaders($headers)->setRows($rows)->render();
    }
}