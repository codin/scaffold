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
        $migrator = container()->get('migrator');

        $table = new Table($output);
        
        $rows = [];
        $headers = ['Migration', 'Status', 'Error'];

        $migrations = $migrator->getAllMigrations();

        foreach ($migrations as $filename => $migration) {
            if ($migrator->checkDatabaseForMigration($filename)) {
                continue;
            }

            $error = '';

            try {
                $migration->up();
                $migrator->addMigrationToDatabase($filename);
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }

            $rows[] = [
                $filename, 
                empty($error) ? 'Success' : 'Failed',
                $error,
            ];
        }

        if (!empty($rows)) {        
            $table->setHeaders($headers)->setRows($rows)->render();
        }

        $output->writeln('No migrations to run.');
    }
}