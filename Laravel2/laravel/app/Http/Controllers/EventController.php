<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index(Request $request) {
        $cars = Event::orderBy("created_at")->get();
        $response = [$cars->toArray()];
        return response($response, 200);
    }

    public function get(Request $request) {
        $id = $request->route('id');
        $cars = Event::findOrFail($id);
        $response = [$cars->toArray()];
        return response($response, 200);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string',
            'title' => 'required|string|max:255',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $ticket = Event::create($request->toArray());
        $id= $request->user()->id;
        $ticket->user_id = $id;
        $ticket->save();
        $response = [$ticket->toArray()];
        return response($response, 200);
    }

}
