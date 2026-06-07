<?php

namespace App\Models\Admin;

use App\Enums\CommonStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'status',
    ];

    protected $casts = [
        'status' => CommonStatus::class
    ];
}
