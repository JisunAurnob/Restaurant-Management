<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public function products(){
        return $this->hasMany(Product::class, 'menu_id');
    }

    public function restaurant(){
        return $this->belongsTo(Restaurant::class, 'id');
    }
}
