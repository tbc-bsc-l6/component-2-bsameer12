<?php

namespace App\Http\Controllers;

use App\Models\slide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $slides = slide::where('status',1)->get()->take(3);
        return view('index',compact('slides'));
    }
}
