<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnPartner extends Model
{
    protected $fillable = [
        'referenceid', 'f88note', 'statusf88','loanmoneyorg','lastcomment'
    ];
}
