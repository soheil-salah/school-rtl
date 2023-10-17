<?php

namespace App\Modules\Admins\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'admin_id', 'dark_mode', 'image',
    ];

    public function BelongsToAdmin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
