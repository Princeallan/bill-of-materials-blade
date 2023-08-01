<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'uom',
        'is_active',
        'is_default',
        'allow_alternative',
        'rate_set',
        'quantity',
        'user_id',
        'items_count',
        'project'
    ];
}
