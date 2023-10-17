<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalStage extends Model
{
    use HasFactory;

    protected $table = 'educational_stages';

    protected $fillable = [
        'name', 'thumbnail', 'content', 'isPublished', 'slug',
    ];

    public function educationalYears()
    {
        return $this->hasMany(EducationalYear::class, 'educational_stage_id', 'id');
    }
}
