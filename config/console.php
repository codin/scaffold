<?php

/**
 * Console app configuration.
 */
return [

    // These commands will be available
    // to the Scaffold console app.
    'commands' => [

        // Database migration commands
        Scaffold\Database\Command\Migration\Generate::class,
        Scaffold\Database\Command\Migration\Rollback::class,
        Scaffold\Database\Command\Migration\Rollback::class,

        // Your custom commands below here...
        App\Console\ExampleCommand::class,
    ],
];