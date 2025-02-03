<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionLog extends Model
{
    use HasFactory;

    // Nama tabel yang terkait dengan model ini (optional jika tabel sudah mengikuti konvensi Laravel)
    protected $table = 'production_log';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'date',
        'product_type',
        'good_product',
        'total_defect',
        'user_name',
    ];

    // Jika kamu menggunakan timestamp otomatis, maka Laravel akan menambah created_at dan updated_at
    public $timestamps = true;
}
