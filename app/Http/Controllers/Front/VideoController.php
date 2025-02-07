<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::paginate(12);
        return view('front.video-gallery', compact('videos'));
    }
}
