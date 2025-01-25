<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'slug',
        'iamge',
        'is_active',
    ];


    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
