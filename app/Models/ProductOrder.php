<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use HasFactory;
    protected $table = 'product_orders';
    protected $fillable = [
        'product_size',
        'product_color',
        'product_quantity',
        'product_price',
        'order_id',
        'user_id',
    ];
}
