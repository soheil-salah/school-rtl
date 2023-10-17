<?php

namespace App\Modules\Admins\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gallery\GalleryAlbum;
use App\Models\Gallery\GalleryPhoto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use InvalidArgumentException;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::all();

        return view('admin.gallery.index', compact('albums'));
    }

    public function show($slug)
    {
        $album = GalleryAlbum::where('slug', $slug)->first();
        
        $album == null ? abort(404) : true;

        return view('admin.gallery.show', compact('album'));
    }

    public function createNewAlbum(Request $request)
    {
        
        if(GalleryAlbum::where('slug', Str::slug($request->album))->first() != null){

            throw new Exception('هذا الالبوم موجود مسبفا من فضلك اختر اسم اخر');
        }

        $thumbnail = $request->file('thumbnail');

        $thumbnail_name = $thumbnail == null ? null : md5(uniqid()).'.'.$thumbnail->extension();

        $album = GalleryAlbum::firstOrCreate([
            'album_name' => $request->album,
            'thumbnail' => $thumbnail_name,
            'slug' => Str::slug($request->album),
        ]);

        if($request->hasFile('thumbnail')){

            $thumbnail->move(public_path('uploads/gallery-album/'.$album->slug.'/thumbnail'), $thumbnail_name);
        }
    }
    
    public function deleteAlbum(Request $request)
    {
        GalleryAlbum::where('id', $request->album_id)->delete();
    }

    public function updateAlbumTitle(Request $request)
    {
        if(empty($request->album_name)){

            throw new Exception('من فضلك اكتب اسم الالبوم');
        }

        $album = GalleryAlbum::where('id', $request->album_id)->first();
        
        if(GalleryAlbum::where('slug', Str::slug($request->album_name))->first() != null){
         
            throw new Exception('اسم الالبوم موجود مسبقا برجاء اختر اسم اخر');
        }

        $old_folder = public_path('uploads/gallery-album/'.$album->slug);
        $new_folder = public_path('uploads/gallery-album/'.Str::slug($request->album_name));
        rename($old_folder, $new_folder);

        GalleryAlbum::where('id', $request->album_id)->update([
            'album_name' => $request->album_name,
            'slug' => Str::slug($request->album_name),
        ]);
    }

    public function updateAlbumThumbnail(Request $request)
    {
        $album_id = $request->album_id;

        $album = GalleryAlbum::where('id', $album_id)->first();

        if($album->thumbnail != null){

            $old_thumbnail = public_path('uploads/gallery-album/'.$album->slug.'/thumbnail/'.$album->thumbnail);

            file_exists($old_thumbnail) ? unlink($old_thumbnail) : true;
        }

        $thumbnail = $request->file('thumbnail');

        $thumbnail_name = md5(uniqid()).'.'.$thumbnail->extension();

        $thumbnail->move(public_path('uploads/gallery-album/'.$album->slug.'/thumbnail'), $thumbnail_name);

        $album->update([
            'thumbnail' => $thumbnail_name
        ]);
    }

    public function deleteAlbumThumbnail(Request $request)
    {
        $album_id = $request->album_id;

        $album = GalleryAlbum::where('id', $album_id)->first();

        if($album->thumbnail != null){

            $this->deleteDir(public_path('uploads/gallery-album/'.$album->slug.'/thumbnail'));
        }

        $album->update([
            'thumbnail' => null
        ]);
    }

    public function uploadPhotos(Request $request)
    {
        $album = GalleryAlbum::where('id', $request->album_id)->first();

        $image = $request->file('file');
        $imageName = md5(uniqid()).'.'.$image->extension();
        $image->move(public_path('uploads/gallery-album/'.$album->slug), $imageName);
        
        GalleryPhoto::create([
            'gallery_album_id' => $request->album_id,
            'image_name' => $imageName,
            'slug' => md5(uniqid())
        ]);
    }

    public function deletePhoto(Request $request)
    {
        GalleryPhoto::where('id', $request->photo_id)->delete();
    }

    public function deleteAllPhotosInAlbum(Request $request)
    {
        $album = GalleryAlbum::where('id', $request->album_id)->first();

        foreach($album->photos as $photo){

            $photo->delete();
        }
    }

    public function publishAlbum(Request $request)
    {
        GalleryAlbum::where('id', $request->album_id)->update([
            'isPublic' => 1,
        ]);
    }

    public function unpublishAlbum(Request $request)
    {
        GalleryAlbum::where('id', $request->album_id)->update([
            'isPublic' => 0,
        ]);
    }

    private function deleteDir($dirPath) 
    {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }

        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        
        $files = glob($dirPath . '*', GLOB_MARK);

        foreach ($files as $file) {

            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}
