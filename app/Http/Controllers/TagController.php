<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function addTag(Request $request)
    {
        $request->validate([
            'tagName' => 'required',
        ]);

        return Tag::create([
            'tagName' => $request->tagName,
        ]);
    }

    public function editTag(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'tagName' => 'required',
        ]);

        return Tag::where('id', $request->id)->update([
            'tagName' => $request->tagName,
        ]);
    }

    public function deleteTag(Request $request)
    {
        return Tag::find($request->id)->delete();
    }

    public function getTag()
    {
        return Tag::orderBy('id', 'desc')->get();
    }
}
