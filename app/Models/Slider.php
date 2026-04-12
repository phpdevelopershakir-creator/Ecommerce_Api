<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title',
        'link',
        'image',
    ];

    protected $appends = ['image_url'];
    public function getImageUrlAttribute()
    {
        if ($this->image == "") {
            return "";
        }
        return asset('uploads/sliders/' . $this->image);
    }
}
