<?php

namespace App\Models\Admin;

use App\Casts\ImageField;
use App\Traits\DeletesImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, DeletesImage;
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'value',
        'regular_price',
        'sale_price',
        'image',
        'gallery_image',
        'is_variation',
        'is_best_sale',
        'is_hot_sale',
        'short_description',
        'description',
        'active_status'
    ];

    protected $casts = [
        'image' => ImageField::class . ':products',
        'status' => \App\Enums\ProductStatus::class,
        'active_status' => \App\Enums\CommonStatus::class,
        // 'gallery_image' => 'array',
        'gallery_image' => \App\Casts\GalleryImageField::class,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function productVariations()
    {
        return $this->hasMany(ProductVariation::class);
    }
}
