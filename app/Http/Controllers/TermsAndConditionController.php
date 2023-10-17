<?php

namespace App\Http\Controllers;

use App\Models\TermsAndCondition;
use Illuminate\Http\Request;

class TermsAndConditionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function termsAndConditions()
    {
        $terms = TermsAndCondition::first();

        return view('admin.terms-and-conditions', compact('terms'));
    }

    public function update(Request $request)
    {

        if(TermsAndCondition::count() == 0){

            TermsAndCondition::create([
                'content' => $request->terms
            ]);

        }else{

            TermsAndCondition::first()->update([
                'content' => $request->terms
            ]);
        }
    }
}
