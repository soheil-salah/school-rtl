<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'guardian_id', 'student_id', 'educational_year_id', 'phone', 'email', 'slug',
    ];

    public function guardian()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function educationalYear()
    {
        return $this->belongsTo(EducationalYear::class, 'educational_year_id', 'id');
    }
}
