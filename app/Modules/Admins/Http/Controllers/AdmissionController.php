<?php

namespace App\Modules\Admins\Http\Controllers;

use App\Models\Admission;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index()
    {
        $admissions = Admission::get()->unique('phone');

        return view('admin.admissions', compact('admissions'));
    }
}
