<?php

namespace App\Modules\Admins\Http\Controllers\GuardianAndStudents;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::get();

        return view('admin.students.index', compact('students'));
    }
}
