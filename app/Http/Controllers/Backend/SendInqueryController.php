<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Inquery;
use Illuminate\Http\Request;

class SendInqueryController extends Controller
{
    public function send(Request $request)
    {
        Inquery::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'msg_subject' => $request->msg_subject,
            'message' => $request->message,
            'slug' => md5(uniqid()),
        ]);
    }
}
