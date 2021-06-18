<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car_Category;

class CarCategoryController extends Controller
{
    public function get(Request $request){
        $categories = Car_Category::get();
        $response = [$categories->toArray()];
        return response($response, 200);
    }
}
