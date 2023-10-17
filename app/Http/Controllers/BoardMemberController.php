<?php

namespace App\Http\Controllers;

use App\Models\BoardMember;
use Illuminate\Http\Request;

class BoardMemberController extends Controller
{
    public function index()
    {
        $boardMembers = BoardMember::where('isHidden', 0)->get();

        return view('pages.board-members.index', compact('boardMembers'));
    }

    public function show($slug)
    {
        $boardMember = BoardMember::where('slug', $slug)->where('isHidden', 0)->first();
        
        $boardMember == null ? abort(404) : true;

        return view('pages.board-members.show', compact('boardMember'));
    }
}
