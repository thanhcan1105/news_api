<?php

namespace App\Http\Controllers\Product;

use App\Models\Future\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //

    public function getCategory(){
        $list = Category::get();
        return $this->responseOK($list);
    }
}
