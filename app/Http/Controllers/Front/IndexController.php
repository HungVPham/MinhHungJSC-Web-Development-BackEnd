<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class IndexController extends Controller
{
    public function index(){
        // Get Featured Items
        $featuredItemsCount = Product::where('is_featured', 'Yes')->count();
        $featuredItems = Product::where('is_featured', 'Yes')->get()->toArray();
        $featuredItemsChunk = array_chunk($featuredItems, 4);
        $page_name = "index";
        return view('front.index')->with(compact('page_name', 'featuredItemsCount', 'featuredItemsChunk'));
    }
}
