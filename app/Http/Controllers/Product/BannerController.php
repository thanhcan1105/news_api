<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Future\Banner;

class BannerController extends Controller
{
    //
    public function getBanner(){
        $list = Banner::get();
        return $this->responseOK($list);
    }
}
