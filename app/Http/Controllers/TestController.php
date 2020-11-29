<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function firstMethod()
    {
        return response()->json([
            'msg' => 'we should return only json data ',
        ]);
    }

    public function addadd()
    {
        return 1;
    }
}
