<?php

namespace App\Modules\Admins\Http\Controllers\GuardianAndStudents;

use App\Http\Controllers\Controller;
use App\Models\Guardian;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    public function index()
    {
        $guardians = Guardian::get();

        return view('admin.guardians.index', compact('guardians'));
    }
}
