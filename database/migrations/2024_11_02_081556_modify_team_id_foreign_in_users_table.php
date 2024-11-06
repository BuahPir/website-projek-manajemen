<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTeamIdForeignInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['team_id']); // Remove the existing foreign key
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('set null'); // Add a new foreign key with set null
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['team_id']); // Remove the modified foreign key
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade'); // Restore the original foreign key
        });
    }
}
