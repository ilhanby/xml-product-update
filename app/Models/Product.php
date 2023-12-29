<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'quantity',
        'photo_url',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    protected $attributes = [
        'price' => 0.00,
        'quantity' => 0,
    ];

    public function getNameAttribute($value): string
    {
        return trim($value);
    }

    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = trim($value);
    }

    public function getDescriptionAttribute($value): string
    {
        return trim($value);
    }

    public function setDescriptionAttribute($value): void
    {
        $this->attributes['description'] = trim($value);
    }

    public function getPriceAttribute($value): float
    {
        return (float)$value;
    }

    public function setPriceAttribute($value): void
    {
        $this->attributes['price'] = (float)$value;
    }

    public function getQuantityAttribute($value): int
    {
        return (int)$value;
    }

    public function setQuantityAttribute($value): void
    {
        $this->attributes['quantity'] = (int)$value;
    }

    public function getPhotoUrlAttribute($value): string
    {
        return trim($value);
    }

    public function setPhotoUrlAttribute($value): void
    {
        $this->attributes['photo_url'] = trim($value);
    }
}
