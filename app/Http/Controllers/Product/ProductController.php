<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Future\Products;

class ProductController extends Controller
{
    //
    public function getProduct()
    {
        $list = Products::orderBy('is_new', 'DESC')->get();
        return $this->responseOK($list);
    }
}
