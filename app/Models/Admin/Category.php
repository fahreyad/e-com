<?php

namespace App\Models\Admin;

use App\Casts\ImageField;
use App\Enums\CategoryStatus;
use App\Enums\CommonStatus;
use App\Traits\DeletesImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, DeletesImage;

    protected $fillable = [
        'category_name',
        'slug',
        'image',
        'banner_image',
        'status',
        'home_page_position',
        'serial',
        'active_status'
    ];

    protected $casts = [
        'status' => CategoryStatus::class,
        'active_status' => CommonStatus::class,
        'image' => ImageField::class . ':category',
        'banner_image' => ImageField::class . ':category',

    ];


    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
