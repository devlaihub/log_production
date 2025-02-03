<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionLogTable extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel production_log.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_log', function (Blueprint $table) {
            $table->id();                                    // Kolom id sebagai primary key
            $table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP')); // Kolom date dengan default waktu sekarang
            $table->string('product_type', 50);               // Kolom product_type dengan panjang 50 karakter
            $table->integer('good_product');                  // Kolom good_product untuk jumlah produk yang baik
            $table->integer('total_defect');                  // Kolom total_defect untuk jumlah produk cacat
            $table->timestamps();                             // Kolom created_at dan updated_at
        });
    }

    /**
     * Batalkan migrasi (drop tabel production_log).
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_log');
    }
}
