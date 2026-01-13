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
        // HAPUS change tipe kolom di sini
    });

    // query manual agar PostgreSQL mau konversi
    DB::statement('ALTER TABLE production_log ALTER COLUMN sg TYPE numeric(5,2) USING sg::numeric;');
}

public function down()
{
    DB::statement('ALTER TABLE production_log ALTER COLUMN sg TYPE varchar;');
}

};
