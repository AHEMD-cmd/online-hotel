<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Feature;
use App\Models\Testimonial;
use App\Models\Post;
use App\Models\Room;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::get();
        $features = Feature::get();
        $testimonials = Testimonial::get();
        $posts = Post::orderBy('id','desc')->limit(3)->get();
        $rooms = Room::take(4)->get();

        return view('front.home', compact('sliders','features','testimonials','posts','rooms'));
    }
}
