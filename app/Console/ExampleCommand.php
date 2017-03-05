<?php 

namespace App\Console;

use Scaffold\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExampleCommand extends Command
{
    protected $name = 'example';

    protected $description = 'Example console command.';

    protected $help = 'Running this command will output "Hello World".';

    /**
     * Handle execution of this command.
     * 
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Hello World');
    }   
}