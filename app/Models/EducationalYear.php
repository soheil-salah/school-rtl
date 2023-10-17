<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'educational_stage_id', 'name', 'order', 'isPublished', 'slug',
    ];

    public function belongsToEducationalStage()
    {
        return $this->belongsTo(EducationalStage::class, 'educational_stage_id', 'id');
    }
}
