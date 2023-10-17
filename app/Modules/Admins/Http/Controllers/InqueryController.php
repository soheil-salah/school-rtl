<?php

namespace App\Modules\Admins\Http\Controllers;

use App\Models\Inquery;
use Illuminate\Http\Request;

class InqueryController extends Controller
{
    public function inqueries()
    {
        $inqueies = Inquery::all();

        $count_unread_inqueries = Inquery::onlyTrashed()->count();

        return view('admin.inqueries.index', compact('inqueies', 'count_unread_inqueries'));
    }

    public function read()
    {
        $inqueies = Inquery::onlyTrashed()->get();

        $count_unread_inqueries = Inquery::onlyTrashed()->count();
        $count_read_inqueries = Inquery::count();

        return view('admin.inqueries.read-inqueries', compact('inqueies', 'count_unread_inqueries', 'count_read_inqueries'));
    }

    public function openInqueryMsg(Request $request)
    {
        $inquery = Inquery::where('id', $request->inquery_id)->withTrashed()->first();

        return view('admin.inqueries.inquery-msg', compact('inquery'));
    }

    public function markMessageAsRead(Request $request)
    {
        $countInqueies = Inquery::count() - 1;
        $countUnReadInqueies = Inquery::onlyTrashed()->count() + 1;

        echo <<<HTML
        <script>
            $("#inquery-counter").html('{$countInqueies}');
            $("#unread-inquery-counter").html('{$countUnReadInqueies}');
        </script>
        HTML;

        Inquery::where('id', $request->inquery_id)->delete();
    }
}
