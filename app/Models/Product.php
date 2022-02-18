<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'discount_price', 'product_code', 'image', 'image_1', 'image_2', 'image_3', 'description', 'color', 'size', 'brand_id', 'category_id', 'isfeatured'];


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

 


}
