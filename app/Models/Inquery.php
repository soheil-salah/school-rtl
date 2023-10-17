<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquery extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inqueries';

    protected $fillable = [
        'name', 'phone_number', 'msg_subject', 'message', 'slug',
    ];
}
