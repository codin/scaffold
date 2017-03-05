<?php 

namespace Scaffold\Console;

use Scaffold\Foundation\App;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Helper\HelperSet;

/**
 * The console application for Scaffold.
 */
class Application extends ConsoleApplication
{   

    /**
     * Pull in the console app config
     * 
     * @var array
     */
    protected $config;

    /**
     * The base Scaffold app instance.
     * 
     * @var Scaffold\Foundation\App
     */
    protected $app;

    /**
     * Pull in config, setup our commands
     * with the classnames provided in the config.
     */
    public function __construct($root, array $instances)
    {
        parent::__construct();

        $this->boot($root, $instances);

        $this->config = config()->get('console');

        $this->addCommandsFromConfig();
    }

    /**
     * Boot our Scaffold instance.
     * 
     * @param  string $root
     * @param  array  $instances
     * @return void
     */
    private function boot($root, array $instances)
    {
        $this->app = new App($root, $instances, true);
    }

    /**
     * Pull in the commands from the 
     * console configuration file.
     *
     * @return void
     */
    private function addCommandsFromConfig()
    {
        if (!isset($this->config['commands'])) {
            return false;
        }

        foreach ($this->config['commands'] as $command) {
            $instance = new $command;
            $this->add($instance);
        }
    }
}