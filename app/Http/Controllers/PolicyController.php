<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function policy()
    {
        $policy = Policy::first();

        return view('admin.policy', compact('policy'));
    }

    public function update(Request $request)
    {

        if(Policy::count() == 0){

            Policy::create([
                'content' => $request->policy
            ]);

        }else{

            Policy::first()->update([
                'content' => $request->policy
            ]);
        }
    }
}
