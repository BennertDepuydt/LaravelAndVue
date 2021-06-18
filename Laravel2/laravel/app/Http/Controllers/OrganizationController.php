<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index(Request $request){
        $organizations = Organization::get();
        $response = [$organizations->toArray()];
        return response($response, 200);
    }

    public function get(Request $request){
        $id = $request->route('id');
        $organizations = Organization::findOrFail($id);
        $response = [$organizations->toArray()];
        return response($response, 200);
    }
}
