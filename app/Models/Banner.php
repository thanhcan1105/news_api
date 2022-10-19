<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    /* Fillable */
    protected $fillable = [
        'company_id', 'image_url', 'status'
    ];

    /* @array $appends */
    public $appends = ['url', 'uploaded_time', 'size_in_kb'];

    public function getAllBanner(){
        return Banner::orderBy('id','DESC')->paginate(10);
    }

    public function getUrlAttribute()
    {
        return Storage::disk('s3')->url($this->iamge_url);
    }
    public function getUploadedTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    
}
