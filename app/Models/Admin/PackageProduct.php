<?php

namespace App\Models\Admin;

use App\Casts\ImageField;
use App\Traits\DeletesImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageProduct extends Model
{
    use HasFactory, DeletesImage;

    protected $fillable = [
        'name',
        'value',
        'regular_price',
        'sale_price',
        'image',
    ];

    protected $casts = [
        'image' => ImageField::class . ':products',
    ];
}
