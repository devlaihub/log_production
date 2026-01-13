<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionLog extends Model
{
    use HasFactory;

    protected $table = 'production_log';

    protected $fillable = [
        'date',
        'product_type',
        'good_product',
        'total_defect',
        'sg',
        'user_name',
    ];

    public $timestamps = true;

    // SG otomatis jadi float
    protected $casts = [
        'sg' => 'float',
    ];
}
