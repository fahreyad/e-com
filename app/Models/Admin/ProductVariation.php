<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variation_id',
        'variation_value',
        'regular_price',
        'sale_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
