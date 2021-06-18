<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function index(Request $request) {
        $jobs = Job::with('organization', "users")->get();
        $response = [$jobs->toArray()];
        return response($response, 200);
    }

    public function get(Request $request) {
        $id = $request->route('id');
        $job = Job::with('organization',"users")->findOrFail($id);
        $response = [$job->toArray()];
        return response($response, 200);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'experience' => 'required|boolean',
            'mic' => 'required|boolean',
            'onlinetime' => 'required|integer',
            'playtime' => 'required|integer',
            'description' => 'required|string',
            'organization_id' => 'required|integer',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $id= $request->user()->id;
        $job = Job::create($request->toArray());
        $job->user_id = $id;
        $job->save();
        $response = [$job->toArray()];
        return response($response, 200);
    }

    public function delete(Request $request) {
        $id = $request->route('id');
        $job = Job::with('organization')->findOrFail($id);
        $job->delete();
        $response = ["deleted"];
        return response($response, 200);
    }
}
