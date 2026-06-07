<?php

namespace App\Models;

use App\Casts\ImageField;
use App\Traits\DeletesImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletSlider extends Model
{
    use HasFactory, DeletesImage;

    protected $fillable = [
        'image',
        'page_link',
    ];

    protected $casts = [
        'image' => ImageField::class . ":outlet_slider",
    ];
}
