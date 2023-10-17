<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug',
    ];

    public function guardian()
    {
        return $this->belongsToMany(Guardian::class, 'student_guardians', 'student_id', 'guardian_id');
    }
}
