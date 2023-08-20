<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [ // 1
        'status',
        'total',
        'ship',
        'customer_name',
        'customer_phone',
        'customer_address',
        'customer_email',
        'note',
        'user_id',
    ];
    public function getWithPaginateBy($userId){
        return $this->whereUserId($userId)->latest('id')->paginate(10);
    }
}
