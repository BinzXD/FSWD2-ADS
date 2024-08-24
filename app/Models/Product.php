<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price'
    ];
    protected static function booted()
    {
        static::deleting(function ($product) {
            $product->assets()->delete();
        });
    }
    public function categori()
    {
        return $this->belongsTo(categorie::class, 'category_id', 'id');
    }
    public function assets()
    {
        return $this->hasMany(Product_asset::class, 'product_id', 'id');
    }
}
