<?php 

use Illuminate\Database\Schema\Blueprint;
use Scaffold\Database\Migration;

class AddMigrationsTable extends Migration 
{
    public function up()
    {
        $this->schema->create('migrations', function(Blueprint $table) {
            $table->increments('id');
            $table->string('migration');
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('migrations');
    }
}