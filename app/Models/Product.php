<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'price',
        'compare_price',
        'category_id',
        'brand_id',
        'sku',
        'qty',
        'barcode',
        'description',
        'short_description',
        'is_featured',
        'status',
        'image'
    ];

    protected $appends = ['image_url'];
    public function getImageUrlAttribute()
    {
        if ($this->image == "") {
            return "";
        }
        return asset('uploads/products/small/' . $this->image);
    }
}
