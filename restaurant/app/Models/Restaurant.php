<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    public function users(){
        return $this->belongsTo(User::class, 'id');
    }

    public function menus(){
        return $this->hasMany(Menu::class, 'restaurant_id');
    }
}
