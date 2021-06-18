<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function index(Request $request) {
        $cars = Ticket::with('users')->get();
        $response = [$cars->toArray()];
        return response($response, 200);
    }

    public function indexuser(Request $request) {
        $id = $request->user()->id;
        $tickets = Ticket::with('users')->where('user_id',$id)->get();
        $response = [$tickets->toArray()];
        return response($response, 200);
    }

    public function get(Request $request) {
        $id = $request->route('id');
        $cars = Ticket::findOrFail($id);
        $response = [$cars->toArray()];
        return response($response, 200);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'msg' => 'required|string|max:255',
                'status' => 'required|string|max:100',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $ticket = Ticket::create($request->toArray());
        $id= $request->user()->id;
        $ticket->user_id = $id;
        $ticket->save();
        $response = [$ticket->toArray()];
        return response($response, 200);
    }

    public function edit(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'msg' => 'required|string|max:255',
            'status' => 'required|string|max:100',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $id = $request->route('id');
        $cars = Ticket::findOrFail($id);
        $cars->title = $request->get('title');
        $cars->msg = $request->get("msg");
        $cars->status = $request->get("status");
        $cars->save();
        $response = [$cars->toArray()];
        return response($response, 200);
    }

    public function editStatus(Request $request) {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|max:100',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $id = $request->route('id');
        $cars = Ticket::findOrFail($id);
        $cars->status = $request->get("status");
        $cars->save();
        $response = [$cars->toArray()];
        return response($response, 200);
    }


    public function delete(Request $request) {
        $id = $request->route('id');
        $cars = Ticket::findOrFail($id);
        $cars->delete();
        $response = ['deleted'];
        return response($response, 200);
    }
}
