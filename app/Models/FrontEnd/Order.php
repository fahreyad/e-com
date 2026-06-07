<?php

namespace App\Models\FrontEnd;

use App\Models\Admin\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'note',
        'subtotal_amount',
        'delivery_amount',
        'total_amount',
        'delivery_method',
        'payment_method',
        'status',
        'order_number',
        'order_date',
        'confirmed_date',
        'processing_date',
        'delivered_date',
        'cancelled_date',
        'store_by',
        'branch_id'

    ];

    protected $casts = [
        'order_date' => 'date',
        'processing_date' => 'date',
        'delivered_date' => 'date',
        'cancelled_date' => 'date',
        'status' => \App\Enums\OrderStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
