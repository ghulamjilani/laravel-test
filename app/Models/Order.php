<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_No',
        'user_id',
        'total_price',
        'order_type',
        'product_id',
        'quantity',
        'delivery_contact_no',
        'delivery_address'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function generateOrderNo()
    {
        $string_start = 'abcd';
        $string_end = 'XYZ';
        $orderNo = rand(1000, 9999);
        return '#'.str_shuffle($string_start).$orderNo.str_shuffle($string_end);
    }
}
