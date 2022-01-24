<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = ['product_name', 'product_code', 'amount', 'reference', 'quantity', 'total', 'status', 'total_items', 'grand_total', 'user_id', 'shipping_id'];
}
