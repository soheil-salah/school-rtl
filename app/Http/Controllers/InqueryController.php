<?php

namespace App\Http\Controllers;

use App\Models\Inquery;
use Illuminate\Http\Request;

class InqueryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function inqueries()
    {
        $inqueies = Inquery::all();

        return view('admin.inqueries.index', compact('inqueies'));
    }

    public function openInqueryMsg(Request $request)
    {
        $inquery = Inquery::where('id', $request->inquery_id)->first();

        return view('admin.inqueries.inquery-msg', compact('inquery'));
    }

    public function markMessageAsRead(Request $request)
    {
        $countInqueies = Inquery::count() - 1;

        echo <<<HTML
        <script>
            $("#inquery-counter").html('{$countInqueies}');
        </script>
        HTML;

        Inquery::where('id', $request->inquery_id)->delete();
    }
}
