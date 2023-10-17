<?php

namespace App\Models\Gallery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryAlbum extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gallery_albums';

    protected $fillable = [
        'album_name', 'thumbnail', 'isPublic', 'slug',
    ];

    public function photos()
    {
        return $this->hasMany(GalleryPhoto::class, 'gallery_album_id', 'id');
    }
}
