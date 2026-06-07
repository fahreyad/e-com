<?php

namespace App\Models;

use App\Casts\ImageField;
use App\Models\FrontEnd\Order;
use App\Traits\DeletesImage;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
       use HasFactory, LaratrustUserTrait, DeletesImage;

    protected $fillable = [
        'username',
        'name',
        'phone',
        'email',
        'email_verified_at',
        'password',
        'avatar',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'avatar' => ImageField::class . ':avatar,images/avatar.png',
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
