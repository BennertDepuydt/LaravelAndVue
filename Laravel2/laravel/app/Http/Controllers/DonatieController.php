<?php

namespace App\Http\Controllers;

use App\Models\Donatie;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DonatieController extends Controller
{
    public function index(Request $request) {
        $cars = Donatie::with('users')->orderBy("created_at")->get();
        $response = [$cars->toArray()];
        return response($response, 200);
    }

    public function indexuser(Request $request) {
        $id = $request->user()->id;
        $tickets = Donatie::with('users')->where('user_id',$id)->orderBy("created_at")->get();
        $response = [$tickets->toArray()];
        return response($response, 200);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $ticket = Donatie::create($request->toArray());
        $id= $request->user()->id;
        $ticket->user_id = $id;
        $ticket->save();
        $response = [$ticket->toArray()];
        return response($response, 200);
    }
}
