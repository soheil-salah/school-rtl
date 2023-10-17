<?php

namespace App\Http\Controllers;

use App\Models\Inquery;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $inqueries = Inquery::get();

        return view('admin.home', compact('inqueries'));
    }

    public function admissions()
    {
        return view('admin.admissions');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
