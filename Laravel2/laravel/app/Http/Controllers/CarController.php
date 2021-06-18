<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Car_Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CarController extends Controller
{
    public function index(Request $request) {
        $cars = Car::with('category')->get();
        $response = [$cars->toArray()];
        return response($response, 200);
    }

    public function get(Request $request) {
        $id = $request->route('id');
        $cars = Car::with('category')->findOrFail($id);
        $response = [$cars->toArray()];
        return response($response, 200);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'year' => 'required|string|min:4|max:4',
            'price' => 'required|string|max:100',
            'modelname' => 'required|string|max:100',
            'car_categories_id' => 'required|int|max:100',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = Car::create($request->toArray());
        $response = [$user->toArray()];
        return response($response, 200);
    }

    public function edit(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'year' => 'required|string|min:4|max:4',
            'price' => 'required|string|max:100',
            'modelname' => 'required|string|max:100',
            'car_categories_id' => 'required|int|max:100',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $id = $request->route('id');
        $cars = Car::with('category')->findOrFail($id);
        $cars->name = $request->get('name');
        $cars->year = $request->get("year");
        $cars->price = $request->get("price");
        $cars->modelname = $request->get("modelname");
        $cars->car_categories_id = $request->get("car_categories_id");
        $cars->save();
        $response = [$cars->toArray()];
        return response($response, 200);
    }

    public function delete(Request $request) {
        $id = $request->route('id');
        $cars = Car::with('category')->findOrFail($id);
        $cars->delete();
        $response = ["deleted"];
        return response($response, 200);
    }
}
