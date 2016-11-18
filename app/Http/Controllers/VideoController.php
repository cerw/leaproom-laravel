<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function store(Request $request)
    {
        $path = $request->file('video-blob')->store('videos');
        echo $path;
    }
}
