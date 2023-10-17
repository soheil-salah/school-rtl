<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'slug',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_guardians', 'guardian_id', 'student_id');
    }
}
