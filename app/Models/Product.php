<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'category_id',
        'brand_id',
        'name',
        'slug',
        'description',
        'price',
        'is_active',
        'is_featured',
        'is_stock',
        'is_sale',
    ];

    protected $casts=[
        'images' =>'array',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

  public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderitem()
    {
        return $this->hasMany(OrderItem::class);
    }

}
