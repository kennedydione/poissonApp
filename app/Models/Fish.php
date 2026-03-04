<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price_per_kg',
        'quantity_available',
        'description',
        'image',
    ];

    protected $casts = [
        'price_per_kg' => 'decimal:2',
        'quantity_available' => 'integer',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
