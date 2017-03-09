<?php 

namespace Scaffold\Database\Command\Migration;

use Carbon\Carbon;
use Scaffold\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * The command to generate a migration file.
 */
class Generate extends Command
{
    protected $name = 'migrate:generate';

    protected $description = 'Generate a new migration file, timestamped.';

    protected $help = 'Running this command will generate a new timestamped migration file.';

    /**
     * Handle execution of this command.
     * 
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $this->formatClassname($input->getArgument('name'));

        container()->get('migrator')->putMigration($name);

        // Using command parameters to create a new
        // migration file.
        // 
        // php scaffold migrate:generate add_new_table
    }

    /**
     * Configure this commnd with some inputs.
     * 
     * @return void
     */
    protected function configure()
    {
        parent::configure();

        $this->addArgument('name', InputArgument::REQUIRED, 'The name for the migration.');
    }

    /**
     * Format the name of the migration into a timestamped
     * camelcase classname.
     * 
     * @param  string $name
     * @return string
     */
    private function formatClassname($name)
    {
        $time = Carbon::now()->format('YmdHis');
        return $time . '_' . ucfirst(camel_case($name));
    }
}