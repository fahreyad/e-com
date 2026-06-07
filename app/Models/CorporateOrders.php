<?php

namespace App\Models;

use App\Models\Admin\Branch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateOrders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contact_name',
        'company_name',
        'company_phone',
        'designation',
        'email',
        'address',
        'note',
        'subtotal_amount',
        'delivery_amount',
        'total_amount',
        'delivery_area',
        'payment_method',
        'status',
        'order_number',
        'order_date',
        'processing_date',
        'delivered_date',
        'cancelled_date',
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

    public function corporateOrderDetails()
    {
        return $this->hasMany(CorporateOrderDetail::class, 'corporate_order_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
