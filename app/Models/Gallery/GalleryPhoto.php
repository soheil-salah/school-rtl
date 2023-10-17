<?php

namespace App\Models\Gallery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryPhoto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gallery_photos';

    protected $fillable = [
        'gallery_album_id', 'image_name', 'slug',
    ];

    public function belongsToAlbum()
    {
        return $this->belongsTo(GalleryAlbum::class, 'gallery_album_id', 'id');
    }
}
