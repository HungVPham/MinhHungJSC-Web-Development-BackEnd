<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AboutPage;
use Session;
use Validator;

class AboutController extends Controller
{
    public function AboutPages(){
        Session::put('page', 'aboutpages');
        $about_pages = AboutPage::get();
        return view('admin.pages.about_pages')->with(compact('about_pages'));
    }
}
