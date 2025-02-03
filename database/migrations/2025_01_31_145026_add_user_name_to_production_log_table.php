<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('production_log', function (Blueprint $table) {
            $table->string('user_name')->nullable();  // Add user_name column to store the name of the user
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('production_log', function (Blueprint $table) {
            $table->dropColumn('user_name');  // Drop user_name column if rollback
        });
    }
};
