<?php

namespace App\Models\Future;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public function category(){
        return $this->hasMany(Category::class, 'id', 'category_id');
    }
}
