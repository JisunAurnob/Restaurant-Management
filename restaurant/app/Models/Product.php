<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function product_attributes(){
        return $this->hasMany(Product_attribute::class, 'product_id');
    }
}
