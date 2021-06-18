<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class SearchCarController extends Controller
{
    public function search(Request $request){
        // Get the search value from the request
        $search = $request->route('search');

        // Search in the title and body columns from the posts table
        $cars = Car::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('modelname', 'LIKE', "%{$search}%")
            ->get();

        // Return the search view with the resluts compacted
        return response($cars, 200);
    }
}
