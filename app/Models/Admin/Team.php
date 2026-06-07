<?php

namespace App\Models\Admin;

use App\Casts\ImageField;
use App\Traits\DeletesImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory, DeletesImage;

    protected $fillable = [
        'serial',
        'image',
        'name',
        'designation',
        'fb_link',      
        'youtube_link',        
    ];

    protected $casts = [
        'image' => ImageField::class . ':team',
    ];
}
