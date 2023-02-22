<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLists extends Model
{
    use HasFactory;

    public $table = "news_lists";


    protected $fillable = [
        'link', 'title', 'image', 'short_description', 'description', 'date'
    ];
}
