<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CmsPage;
use Session;


class BlogsController extends Controller
{
    public function Blogs(Request $request){
        return view('front.blogs.blogs');
    }
}
