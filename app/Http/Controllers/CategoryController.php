<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpeg,jpg,png',
        ]);
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

    public function deleteImage(Request $request)
    {
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName, false);
        return 'done';
    }

    public function deleteFileFromServer($fileName, $hasFullPath = false)
    {
        if (!$hasFullPath) {
            $filePath = public_path().'/uploads/'.$fileName;
        }
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        return;
    }

    public function addCategory(Request $request)
    {
        $request->validate([
            'categoryName' => 'required',
            'iconImage' => 'required',
        ]);

        return Category::create([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage,
        ]);
    }

    public function getCategory()
    {
        return Category::orderBy('id', 'desc')->get();
    }

    public function editCategory(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'categoryName' => 'required',
            'iconImage' => 'required',
        ]);

        return Category::where('id', $request->id)->update([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage,
        ]);
    }
}
