<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'board_members';

    protected $fillable = [
        'name', 'title', 'about', 'image', 'phone', 'isHidden', 'slug',
    ];
}
