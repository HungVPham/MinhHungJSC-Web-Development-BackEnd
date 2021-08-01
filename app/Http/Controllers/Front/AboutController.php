<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AboutPage;

class AboutController extends Controller
{
    public function AboutPage(){
        $currentRoute = url()->current();
        $currentRoute = str_replace("http://127.0.0.1:8000/gioi-thieu/", "",$currentRoute);
        $aboutRoutes = AboutPage::where('status', 1)->get()->pluck('url')->toArray();
        // dd($cmsRoutes); die;
        if(in_array($currentRoute, $aboutRoutes)){
            $aboutPageDetails = AboutPage::where('url',$currentRoute)->first()->toArray();
            return view('front.pages.about_page')->with(compact('aboutPageDetails'));
        }else{
            abort(404);
        }
    }
}
