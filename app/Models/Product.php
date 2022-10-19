<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
       'name','phone','select1','link'
       ,'transaction_id','reference_type','reference_id','current_group_id','transaction_id','source','campaign',
       'str_source_group','str_secondary_source','isdigital'
    ];
    public function comments()
    {
        return $this->hasMany(Comment::class,'product_id','id');
    }
}
