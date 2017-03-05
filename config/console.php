<?php

/**
 * Console app configuration.
 */
return [

    // These commands will be available
    // to the Scaffold console app.
    'commands' => [

        // Database migration commands
        // Scaffold\Database\Migration\Migrate::class,
        // Scaffold\Database\Migration\Rollback::class,

        // Your custom commands below here...
        App\Console\ExampleCommand::class,
    ],
];