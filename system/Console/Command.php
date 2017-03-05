<?php 

namespace Scaffold\Console;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Represent a console command.
 */
abstract class Command extends SymfonyCommand
{

    /**
     * The name of the command we use to call
     * it in the console app.
     * 
     * @var string
     */
    protected $name = 'my-command';

    /**
     * A description of the command.
     * 
     * @var string
     */
    protected $description = 'This is my command';

    /**
     * The help text for the command.
     * 
     * @var string
     */
    protected $help = 'Some help text';

    /**
     * Override the configure method to setup
     * the basic command information from the
     * protected properties.
     * 
     * @return void
     */
    protected function configure()
    {        
        $this->setName($this->name)
            ->setDescription($this->description)
            ->setHelp($this->help); 
    }
}