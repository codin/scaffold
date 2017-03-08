<?php 

namespace Scaffold\Database\Command\Migration;

use Scaffold\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * The command to rollback a migration
 */
class Rollback extends Command
{   
    protected $name = 'migrate:rollback';

    protected $description = 'Rollback a migration';

    protected $help = 'Running this command will rollback the latest migration.';

    /**
     * Handle execution of this command.
     * 
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get latest migration
        // Pull in the class
        // Run the `down()` method.
        // 
        // php scaffold migrate:rollback
    }
}