<?php

namespace App\Models;

use App\Models\Admin\PackageProduct;
use App\Models\Admin\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateOrderDetail extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'corporate_order_id',
        'product_id',
        'value',
        'price',
        'quantity',
        'subtotal',
        'deleted_at',
    ];

    public function corporateOrders()
    {
        return $this->belongsTo(CorporateOrders::class);
    }

    public function packageProduct()
    {
        return $this->belongsTo(PackageProduct::class, 'product_id');
    }
}
