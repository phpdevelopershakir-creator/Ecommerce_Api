<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
