<?php

namespace App\Models\Admin;

use App\Casts\ImageField;
use App\Traits\DeletesImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory, DeletesImage;

    protected $fillable = [
        'image',
        'serial',
    ];
    protected $casts = [
        'image' => ImageField::class . ':gallery',
    

    ];
}
