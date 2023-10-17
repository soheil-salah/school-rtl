<?php

namespace App\Modules\Admins\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BoardMember;
use Exception;
use Illuminate\Http\Request;

class BoardMemberController extends Controller
{
    public function index()
    {
        $boardMembers = BoardMember::all();

        return view('admin.board-members.index', compact('boardMembers'));
    }
    
    public function show($slug)
    {
        $boardMember = BoardMember::where('slug', $slug)->first();

        return view('admin.board-members.show', compact('boardMember'));
    }
    
    public function addMewBoardMember(Request $request)
    {
        $name = $request->board_member_name;
        $title = $request->board_member_title;
        $about = $request->about_board_member;
        $image_name = null;
        $phone = $request->board_member_phone;
        $slug = md5(uniqid());

        if(BoardMember::where('phone', $phone)->first() != null){
            
            throw new Exception('رقم الهاتف يتبع لعضو اخر');
        }

        if($request->hasFile('board_member_image')){

            $image_name = md5(uniqid()).'.'.$request->file('board_member_image')->extension();

            $teacher_path = public_path('uploads/board-members/teachers/'.$slug);

            $request->file('board_member_image')->move($teacher_path, $image_name);
        }

        BoardMember::firstOrCreate([
            'name' => $name,
            'title' => $title,
            'about' => $about,
            'image' => $image_name,
            'phone' => $phone,
            'slug' => $slug,
        ]);
    }

    public function updateInfo(Request $request)
    {
        $board_member_id = $request->board_member_id;

        $boardMember = BoardMember::where('id', $board_member_id)->first();

        $name = $request->board_member_name;
        $title = $request->board_member_title;
        $about = $request->about_board_member;
        $phone = $request->board_member_phone;

        $boardMember->update([
            'name' => $name,
            'title' => $title,
            'about' => $about,
            'phone' => $phone,
        ]);
    }

    public function updateImage(Request $request)
    {
        $board_member_id = $request->board_member_id;

        $boardMember = BoardMember::where('id', $board_member_id)->first();

        # get old image
        $board_member_image = public_path('uploads/board-members/teachers/'.$boardMember->slug.'/'.$boardMember->image);

        # delete old image
        file_exists($board_member_image) && !is_dir($board_member_image) ? unlink($board_member_image) : true;

        # upload new image
        $image_name = md5(uniqid()).'.'.$request->file('board_member_image')->extension();
        $board_member_path = public_path('uploads/board-members/teachers/'.$boardMember->slug);
        $request->file('board_member_image')->move($board_member_path, $image_name);

        # update image data in the database
        $boardMember->update([
            'image' => $image_name
        ]);
    }

    public function deleteImage(Request $request)
    {
        $board_memeber_id = $request->board_memeber_id;
        
        $boardMember = BoardMember::where('id', $board_memeber_id)->first();

        # get old image
        $board_member_image = public_path('uploads/board-members/teachers/'.$boardMember->slug.'/'.$boardMember->image);

        # delete old image
        file_exists($board_member_image) ? unlink($board_member_image) : true;

        # update image data in the database
        $boardMember->update([
            'image' => null
        ]);
    }

    public function suspend(Request $request)
    {
        $board_memeber_id = $request->board_memeber_id;
        
        BoardMember::where('id', $board_memeber_id)->update([
            'isHidden' => 1,
        ]);
    }

    public function publish(Request $request)
    {
        $board_memeber_id = $request->board_memeber_id;
        
        BoardMember::where('id', $board_memeber_id)->update([
            'isHidden' => 0,
        ]);
    }

    public function delete(Request $request)
    {
        $board_memeber_id = $request->board_memeber_id;
        
        BoardMember::where('id', $board_memeber_id)->delete();
    }
}
