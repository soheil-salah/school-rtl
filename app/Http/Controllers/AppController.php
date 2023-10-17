<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\EducationalYear;
use App\Models\Gallery\GalleryAlbum;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\StudentGuardian;
use App\Models\User;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        return view('index');
    }
    
    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function galleries()
    {
        $albums = GalleryAlbum::where('isPublic', 1)->get();
        
        return view('pages.gallery.index', compact('albums'));
    }
    
    public function gallery($slug)
    {
        $album = GalleryAlbum::where('slug', $slug)->first();

        $album == null ? abort(404) : true;
        $album->isPublic == 0 ? abort(404) : true;

        return view('pages.gallery.show', compact('album'));
    }

    public function admission()
    {
        $educationalYears = EducationalYear::where('isPublished', 1)->get();

        return view('admission', compact('educationalYears'));
    }

    public function sendAdmission(Request $request)
    {
        $guardian_name = $request->guardian_name;
        $guardian_phone = $request->guardian_phone;
        $email = $request->email;
        $student_name = $request->student_name;
        $educational_year = $request->educational_year;

        $guardian = Guardian::firstOrCreate(['email' => $email, 'phone' => $guardian_phone], [
            'name' => $guardian_name,
            'email' => $email,
            'phone' => $guardian_phone,
            'slug' => md5(uniqid()),
        ]);

        $student = Student::create([
            'name' => $student_name,
            'slug' => md5(uniqid()),
        ]);

        StudentGuardian::create([
            'guardian_id' => $guardian->id,
            'student_id' => $student->id,
        ]);

        Admission::create([
            'guardian_id' => $guardian->id,
            'student_id' => $student->id,
            'educational_year_id' => $educational_year,
            'phone' => $guardian_phone,
            'email' => $email,
            'slug' => md5(uniqid()),
        ]);
    }

    public function policy()
    {
        return view('policy');
    }

    public function terms()
    {
        return view('terms');
    }
}